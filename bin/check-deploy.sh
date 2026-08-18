#!/usr/bin/env bash
# So sanh file public tren demo voi mot commit cua repo deploy.
#
#   bin/check-deploy.sh                 # so voi origin/main
#   bin/check-deploy.sh 89757e1         # so voi mot commit bat ky
#
# Chi doc qua HTTP — khong can SSH, khong can password.
set -uo pipefail

REPO="${TTC_REPO:-$HOME/Local Sites/ttctech/repo/ttctech-web}"
BASE="${TTC_DEMO:-https://ttctech-demo.unotech.vn}"
REF="${1:-origin/main}"
SUB="wp-content/themes/blocksy-child"

git -C "$REPO" fetch --quiet origin 2>/dev/null
SHA=$(git -C "$REPO" rev-parse --short "$REF") || { echo "Khong tim thay ref: $REF"; exit 1; }
echo "So demo voi $REF ($SHA)"
echo

ok=0; bad=0
while read -r f; do
	rel="${f#$SUB/}"
	repo_md5=$(git -C "$REPO" show "$REF:$f" | md5 -q)
	tmp=$(mktemp)
	code=$(curl -s -o "$tmp" -w '%{http_code}' "$BASE/$SUB/$rel")
	if [ "$code" != "200" ]; then
		printf '  MISSING  %-46s HTTP %s\n' "$rel" "$code"; bad=$((bad+1))
	elif [ "$(md5 -q "$tmp")" != "$repo_md5" ]; then
		if [ "$(tr -d '\r' < "$tmp" | md5 -q)" = "$repo_md5" ]; then
			printf '  CRLF     %-46s (noi dung dung, sai line-ending)\n' "$rel"
		else
			printf '  KHAC     %-46s\n' "$rel"
		fi
		bad=$((bad+1))
	else
		ok=$((ok+1))
	fi
	rm -f "$tmp"
done < <(git -C "$REPO" ls-tree -r --name-only "$REF" "$SUB" | grep -E "^$SUB/(assets/|style\.css)")

echo
echo "Khop: $ok  |  Lech: $bad"
[ "$bad" -eq 0 ] && echo "=> Demo dang chay dung $SHA (phan file public)."

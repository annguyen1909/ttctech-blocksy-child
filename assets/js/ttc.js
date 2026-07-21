(() => {
	const toggle = document.querySelector(".ttc-nav-toggle");
	const navInner = document.querySelector(".ttc-header__nav-inner");
	if (!toggle || !navInner) return;

	toggle.addEventListener("click", () => {
		const open = navInner.classList.toggle("is-open");
		toggle.setAttribute("aria-expanded", open ? "true" : "false");
	});
})();

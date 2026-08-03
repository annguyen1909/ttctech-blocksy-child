(() => {
	const toggle = document.querySelector(".ttc-nav-toggle");
	const navInner = document.querySelector(".ttc-header__nav-inner");
	if (!toggle || !navInner) return;

	const setOpen = (open) => {
		navInner.classList.toggle("is-open", open);
		toggle.setAttribute("aria-expanded", open ? "true" : "false");
	};

	toggle.addEventListener("click", () => setOpen(!navInner.classList.contains("is-open")));
	navInner.querySelectorAll("a").forEach((link) => link.addEventListener("click", () => setOpen(false)));
	document.addEventListener("keydown", (event) => {
		if (event.key === "Escape" && navInner.classList.contains("is-open")) {
			setOpen(false);
			toggle.focus();
		}
	});
})();

(() => {
	const gallery = document.querySelector(".ttc-product-gallery");
	if (gallery) {
		const main = gallery.querySelector(".ttc-product-gallery__main");
		const thumbs = [...gallery.querySelectorAll(".ttc-product-thumb")];
		let index = 0;

		const show = (next) => {
			index = (next + thumbs.length) % thumbs.length;
			main.src = thumbs[index].dataset.image;
			thumbs.forEach((thumb, current) => {
				const active = current === index;
				thumb.classList.toggle("is-current", active);
				thumb.setAttribute("aria-pressed", active ? "true" : "false");
			});
		};

		thumbs.forEach((thumb, current) => thumb.addEventListener("click", () => show(current)));
		gallery.querySelector(".ttc-product-gallery__arrow--prev")?.addEventListener("click", () => show(index - 1));
		gallery.querySelector(".ttc-product-gallery__arrow--next")?.addEventListener("click", () => show(index + 1));
	}

	const toggle = document.querySelector(".ttc-product-more-toggle");
	const more = document.querySelector(".ttc-product-more");
	if (!toggle || !more) return;

	toggle.addEventListener("click", () => {
		const expanded = toggle.getAttribute("aria-expanded") !== "true";
		toggle.setAttribute("aria-expanded", expanded ? "true" : "false");
		toggle.querySelector("span").textContent = expanded ? "Thu gọn" : "Tìm hiểu thêm";
		more.hidden = !expanded;
	});

	const tabs = [...document.querySelectorAll("[data-product-tab]")];
	const panels = [...document.querySelectorAll("[data-product-panel]")];

	const selectTab = (tab, { focus = false } = {}) => {
		const selected = tab.dataset.productTab;
		tabs.forEach((item) => {
			const active = item === tab;
			item.setAttribute("aria-selected", active ? "true" : "false");
			// Roving tabindex: only the active tab is in the Tab order.
			item.setAttribute("tabindex", active ? "0" : "-1");
		});
		panels.forEach((panel) => {
			panel.hidden = panel.dataset.productPanel !== selected;
		});
		if (focus) tab.focus();
	};

	tabs.forEach((tab, current) => {
		tab.addEventListener("click", () => selectTab(tab));
		tab.addEventListener("keydown", (event) => {
			let next = null;
			switch (event.key) {
				case "ArrowRight":
				case "ArrowDown":
					next = tabs[(current + 1) % tabs.length];
					break;
				case "ArrowLeft":
				case "ArrowUp":
					next = tabs[(current - 1 + tabs.length) % tabs.length];
					break;
				case "Home":
					next = tabs[0];
					break;
				case "End":
					next = tabs[tabs.length - 1];
					break;
				default:
					return;
			}
			event.preventDefault();
			selectTab(next, { focus: true });
		});
	});
})();

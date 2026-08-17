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

(() => {
	const toc = document.querySelector("[data-ttc-toc]");
	if (!toc) {
		return;
	}

	const toggle = toc.querySelector(".ttc-toc__toggle");
	const panel = toc.querySelector(".ttc-toc__panel");
	const links = [...toc.querySelectorAll("[data-ttc-toc-link]")];
	const headerOffset = () => {
		const header = document.querySelector("#header");
		return (header ? header.getBoundingClientRect().height : 96) + 16;
	};

	const setOpen = (open) => {
		toc.dataset.open = open ? "true" : "false";
		toggle?.setAttribute("aria-expanded", open ? "true" : "false");
	};

	toggle?.addEventListener("click", () => {
		setOpen(toc.dataset.open !== "true");
	});

	const scrollToId = (id) => {
		const target = document.getElementById(id);
		if (!target) {
			return;
		}
		const top = target.getBoundingClientRect().top + window.scrollY - headerOffset();
		window.scrollTo({ top, behavior: "smooth" });
	};

	const setActive = (id) => {
		links.forEach((link) => {
			const active = link.getAttribute("href") === `#${id}`;
			link.classList.toggle("is-active", active);
			if (!active || !panel || toc.dataset.open !== "true") {
				return;
			}
			const linkBox = link.getBoundingClientRect();
			const panelBox = panel.getBoundingClientRect();
			if (linkBox.top < panelBox.top || linkBox.bottom > panelBox.bottom) {
				panel.scrollTop += linkBox.top - panelBox.top - panel.clientHeight / 2 + linkBox.height / 2;
			}
		});
	};

	links.forEach((link) => {
		link.addEventListener("click", (event) => {
			const id = (link.getAttribute("href") || "").replace("#", "");
			if (!id) {
				return;
			}
			event.preventDefault();
			setActive(id);
			scrollToId(id);
			history.replaceState(null, "", `#${id}`);
		});
	});

	const ids = links
		.map((link) => (link.getAttribute("href") || "").replace("#", ""))
		.filter(Boolean);
	const headings = ids
		.map((id) => document.getElementById(id))
		.filter(Boolean);

	if (headings.length && "IntersectionObserver" in window) {
		const observer = new IntersectionObserver(
			(entries) => {
				const visible = entries
					.filter((entry) => entry.isIntersecting)
					.sort((a, b) => a.boundingClientRect.top - b.boundingClientRect.top);
				if (visible[0]?.target.id) {
					setActive(visible[0].target.id);
				}
			},
			{
				rootMargin: "-120px 0px -55% 0px",
				threshold: [0, 0.2, 0.5, 1],
			}
		);
		headings.forEach((heading) => observer.observe(heading));
	}

	if (location.hash) {
		const id = decodeURIComponent(location.hash.slice(1));
		if (document.getElementById(id)) {
			setActive(id);
		}
	}
})();

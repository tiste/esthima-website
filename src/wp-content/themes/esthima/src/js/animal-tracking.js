document.addEventListener("DOMContentLoaded", function () {
	// Sélectionner tous les points de la timeline
	const timelinePoints = document.querySelectorAll(".timeline-point");
	const trackingStep = document.querySelector(".tracking-step.dynamic-content");

	if (timelinePoints) {
		timelinePoints.forEach((point) => {
			const stepIndex = point.getAttribute("data-step-index");
			const tooltip = document.getElementById(`tooltip-${stepIndex}`);

			if (tooltip) {
			// Remplacer le contenu de tracking-step au hover
			point.addEventListener("mouseenter", () => {
				if (trackingStep) {
					const stepTitle = tooltip.querySelector(".step-title")?.textContent;
					const stepDate = tooltip.querySelector(".step-date")?.textContent;
					const stepDescription = tooltip.querySelector(
						".timeline-tooltip-body"
					)?.textContent;

					trackingStep.querySelector(
						".step-title"
					).innerHTML = `Étape : ${stepTitle} <span class="step-date">${
						stepDate ?? "à venir"
					}</span>`;
					trackingStep.querySelector(".step-description").textContent =
						stepDescription;
				}
			});

			// Click pour mobile/tactile
			point.addEventListener("click", () => {
				if (trackingStep) {
					const stepTitle = tooltip.querySelector(".step-title")?.textContent;
					const stepDate = tooltip.querySelector(".step-date")?.textContent;
					const stepDescription = tooltip.querySelector(
						".timeline-tooltip-body"
					)?.textContent;

					trackingStep.querySelector(
						".step-title"
					).innerHTML = `Étape : ${stepTitle} <span class="step-date">${
						stepDate ?? "à venir"
					}</span>`;
					trackingStep.querySelector(".step-description").textContent =
						stepDescription;
				}
			});
		}
	});
	};
});

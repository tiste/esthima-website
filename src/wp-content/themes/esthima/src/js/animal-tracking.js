document.addEventListener("DOMContentLoaded", function () {
	// Sélectionner tous les points de la timeline
	const timelinePoints = document.querySelectorAll(".timeline-point");
	const trackingStep = document.querySelector(".tracking-step.dynamic-content");
	
	// Stocker l'étape active et sa description
	let activeStepDescription = "";
	if (trackingStep && trackingStep.querySelector(".step-description")) {
		activeStepDescription = trackingStep.querySelector(".step-description").textContent;
	}

	if (timelinePoints) {
		timelinePoints.forEach((point, index) => {
			const stepIndex = point.getAttribute("data-step-index");
			const tooltip = document.getElementById(`tooltip-${stepIndex}`);

			if (tooltip) {
				// Remplacer uniquement le titre et la date au hover, pas la description
				point.addEventListener("mouseenter", () => {
					if (trackingStep) {
						const stepTitle = tooltip.querySelector(".step-title")?.textContent;
						const stepDate = tooltip.querySelector(".step-date")?.textContent;

						trackingStep.querySelector(
							".step-title"
						).innerHTML = `Étape ${index + 1} : ${stepTitle} <span class="step-date">${
							stepDate ?? "à venir"
						}</span>`;
						
						// Si le point survolé est l'étape active, afficher sa description
						// Sinon, ne pas afficher de description
						if (point.classList.contains("active")) {
							trackingStep.querySelector(".step-description").textContent = activeStepDescription;
						} else {
							// Ne pas afficher de description pour les étapes passées ou à venir
							trackingStep.querySelector(".step-description").textContent = "";
						}
					}
				});

				// Click pour mobile/tactile
				point.addEventListener("click", () => {
					if (trackingStep) {
						const stepTitle = tooltip.querySelector(".step-title")?.textContent;
						const stepDate = tooltip.querySelector(".step-date")?.textContent;

						trackingStep.querySelector(
							".step-title"
						).innerHTML = `Étape ${index + 1} : ${stepTitle} <span class="step-date">${
							stepDate ?? "à venir"
						}</span>`;
						
						// Si le point cliqué est l'étape active, afficher sa description
						// Sinon, ne pas afficher de description
						if (point.classList.contains("active")) {
							trackingStep.querySelector(".step-description").textContent = activeStepDescription;
						} else {
							// Ne pas afficher de description pour les étapes passées ou à venir
							trackingStep.querySelector(".step-description").textContent = "";
						}
					}
				});
			}
		});
	}
});

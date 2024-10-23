import { createApp } from "vue";
import { createPinia } from "pinia";

import Axios from "axios";
import Quill from "quill";
//config
Axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
Axios.defaults.withCredentials = true;

import PrimeVue from "primevue/config";
import Lara from "../../presets/Lara/index.js";

import "quill/dist/quill.snow.css";
import htmlEditButton from "quill-html-edit-button";

Quill.register('modules/htmlEditButton', htmlEditButton);

import Tooltip from "primevue/tooltip";
import ToastService from "primevue/toastservice";
import DialogService from "primevue/dialogservice";
import ConfirmationService from "primevue/confirmationservice";

import App from "./views/App.vue";
import router from "./router";

const pinia = createPinia();

const app = createApp(App)
	.use(router)
	.use(pinia)
    .use(PrimeVue, {
        unstyled: true,
        pt: Lara,
        locale: {
            accept: 'Oui',
            reject: 'Non',
            choose: 'Choisir',
            upload: 'Télécharger',
            cancel: 'Annuler',
            dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            monthNames: [
                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
            ],
            monthNamesShort: [
                'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin',
                'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'
            ],
            today: "Aujourd'hui",
            clear: 'Effacer',
            weekHeader: 'Sem',
            firstDayOfWeek: 1, // Lundi comme premier jour de la semaine
            dateFormat: 'dd/mm/yy',
            weak: 'Faible',
            medium: 'Moyen',
            strong: 'Fort',
            passwordPrompt: 'Entrez un mot de passe',
            emptyMessage: 'Aucun résultat trouvé',
            emptyFilterMessage: 'Aucun résultat trouvé'
        }
    })
	.use(ToastService)
	.use(DialogService)
	.use(ConfirmationService)
	.directive("tooltip", Tooltip);

window.addEventListener("load", function () {
	document.querySelectorAll("#app").forEach((element) => {
		router.isReady().then(() => {
			app.mount("#app");
		});
	});

	document
		.querySelectorAll(".loader.-main")
		.forEach((element) => element.remove());
});

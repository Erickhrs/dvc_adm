import dashboard from "../pages/dashboard.js";
import questionManager from "../pages/questionManager.js";
import statistics from "../pages/statistics.js";
import messages from "../pages/messages.js";
import users from "../pages/users.js";
import history from "../pages/history.js";
import settings from "../pages/settings.js";
import adms from "../pages/adms.js";
import newQuestion from "../pages/newQuestion.js";

const pageMap = {
    '': dashboard,
    '#dashboard': dashboard,
    '#questionManager': questionManager,
    '#statistics': statistics,
    '#messages': messages,
    '#users': users,
    '#history': history,
    '#settings': settings,
    '#adms': adms,
    '#newQuestion': newQuestion
};

const init = () => {
    const path = window.location.pathname;
    const fileName = path.split('/').pop();

    const handleHashChange = () => {
        const page = pageMap[window.location.hash] || dashboard;
        main.innerHTML = "";
        main.appendChild(page());
    };

    window.addEventListener("hashchange", handleHashChange);
    handleHashChange(); // Initial load
};

const menu = document.querySelector(".side-menu");
const main = document.querySelector("#root");

menu.addEventListener("click", init);

window.addEventListener("load", () => {
    const path = window.location.pathname;
    const fileName = path.split('/').pop();

    if (fileName === "system.php") {
        main.appendChild(dashboard());
        init();
    }
});

import dashboard from "../pages/dashboard.js"
import questionManager from "../pages/questionManager.js"
import statistics from "../pages/statistics.js"
import messages from "../pages/messages.js"
import users from "../pages/users.js"
import history from "../pages/history.js"
import settings from "../pages/settings.js"
import adms from "../pages/adms.js"
import newQuestion from "../pages/newQuestion.js"

const init = () => {
    window.addEventListener("hashchange", () => {
        main.innerHTML = ""

        switch (window.location.hash) {
            case "":
                main.appendChild(dashboard());
                break;
            case "#dashboard":
                main.appendChild(dashboard());
                break;
            case "#questionManager":
                main.appendChild(questionManager());
                break;
            case "#statistics":
                main.appendChild(statistics());
                break;
            case "#messages":
                main.appendChild(messages());
                break;
            case "#users":
                main.appendChild(users());
                break;
            case "#history":
                main.appendChild(history());
                break;
            case "#settings":
                main.appendChild(settings());
                break;
            case "#adms":
                main.appendChild(adms());
                break;
            case "#newQuestion":
                main.appendChild(newQuestion());
                break;
        }
    })
}

const main = document.querySelector("#root");
window.addEventListener("load", function () {
    //main.appendChild(dashboard())
    init()
});
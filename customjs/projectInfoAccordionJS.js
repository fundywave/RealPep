HidePanels("All");

function HidePanels(panelName, exception = "none") {
    if (panelName === "All") {
        for (let index = 0; index < 5; index++) {
            var id = "panelinfo" + (index + 1).toString();
            if (id === exception) continue;
            var panelinfoelement = document.getElementById(id);
            if (panelinfoelement != null)
                panelinfoelement.style.display = "none";

        }
    } else {
        document.getElementById(panelName).style.display = "none";
    }
}

function CollapsePanelInfo(panelName) {
    var x = document.getElementById(panelName);
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        HidePanels("All");
        x.style.display = "block";
        window.scrollTo(0, document.body.scrollHeight);
    }
}
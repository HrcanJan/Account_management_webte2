let display = false;

const statistics = document.getElementById("statistics");
const table = document.getElementById("table").tBodies[0];
const table2 = document.getElementById("table2").tBodies[0];

function changeForm(){
    if(!display)
        statistics.style.display = "block";
    else
        statistics.style.display = "none";
    display = !display;

}

fetch("statistics.php", {method: "get"})
    .then(response => response.json())
    .then(result => {
        result.forEach(item => {
            const tr = document.createElement("tr");
            const td = document.createElement("td");
            td.append(item.login);

            tr.append(td);
            table.append(tr);
        })
    })

fetch("statistic2.php", {method: "get"})
    .then(response => response.json())
    .then(result => {
        result.forEach(item => {
            const tr = document.createElement("tr");
            const td = document.createElement("td");
            td.append(item.google);
            const td2 = document.createElement("td");
            td2.append(item.classic);

            tr.append(td);
            tr.append(td2);
            table2.append(tr);
        })
    })
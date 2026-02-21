function lista(){
       const url = searchMaterialPruebas;

    fetch(url)
   .then(response => {
            if (!response.ok) {
                throw new Error("HTTP error " + response.status);
            }
            return response.json();
        })
        .then(data => {
         console.log(data);

const container = document.getElementById('tablaResposiba');

let html = `
<div class="table-responsive">
<table class="table table-striped table-hover table-bordered align-middle">
<thead class="table-dark">
<tr>
<th>Part Number (HARNESS)</th>
<th>Rev</th>
<th>Customer</th>
<th>Priority</th>
<th>Part Number (CONNECTOR)</th>
<th>QTY</th>
<th>Part Number (TERMINAL)</th>
<th>QTY</th>
<th>Fecha Recepción</th>
<th>Fecha Entrega</th>
<th>Status</th>
<th>P.O</th>
<th>Observations</th>
<th>Material at Laredo</th>
<th>ETA (BEA)</th>
</tr>
</thead>
<tbody>
`;

if (data.length === 0) {
    html += `
    <tr>
        <td colspan="15" class="text-center text-muted">
            No records found
        </td>
    </tr>`;
} else {

    data.forEach(element => {

        html += `
        <tr>
            <td>${escapeHtml(element.pn)}</td>
            <td>${escapeHtml(element.rev)}</td>
            <td>${escapeHtml(element.customer)}</td>
            <td>${escapeHtml(element.priority)}</td>
            <td>${escapeHtml(element.connector)}</td>
            <td class="text-end">${element.connectorQty ?? 0}</td>
            <td>${escapeHtml(element.terminal)}</td>
            <td class="text-end">${element.terminalQty ?? 0}</td>
            <td>${formatDate(element.dateRecepcion)}</td>
            <td>${formatDate(element.deliveryDate)}</td>
            <td>${escapeHtml(element.status)}</td>
            <td>${escapeHtml(element.po)}</td>
            <td>${escapeHtml(element.observaciones)}</td>
            <td>${escapeHtml(element.materialAtLaredo)}</td>
            <td>${formatDate(element.eta_bea)}</td>
        </tr>
        `;
    });
}

html += `
</tbody>
</table>
</div>
`;

container.innerHTML = html;


/* helpers */

// evita XSS
function escapeHtml(text) {
    if (!text) return '';
    return text
        .toString()
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

// formato fecha
function formatDate(date) {
    if (!date) return '';
    const d = new Date(date);
    if (isNaN(d)) return date;
    return d.toLocaleDateString('en-CA');
}

        })
        .catch(error => console.error("Error:", error));
        
}


function addNewrequirement(){
    newrequirement = document.getElementById('newrequirement');
    newrequirement.style.display = 'block';
}

window.onload = function() {
    lista();
};

setInterval(function() {
    lista();
}, 5000);
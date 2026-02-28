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
            <tr data-id="${element.id}">
                <td>
                    <input type="text" class="form-control form-control-sm update-field" 
                        data-field="pn" 
                        value="${escapeHtml(element.pn)}">
               </td>
                <td>
                <input type="text" class="form-control form-control-sm update-field" 
                        data-field="rev" 
                        value="${escapeHtml(element.rev)}">
                </td>
                <td>
                <input type="text" class="form-control form-control-sm update-field" 
                        data-field="customer" 
                        value="${escapeHtml(element.customer)}">
                </td>
                <td>
                    <select
                        class="form-control form-control-sm update-field" 
                        data-field="priority"
                        value="${escapeHtml(element.priority)}">
                        <option value="Baja" ${element.priority === 'Baja' ? 'selected' : ''}>Baja</option>
                        <option value="Media" ${element.priority === 'Media' ? 'selected' : ''}>Media</option>
                        <option value="Alta" ${element.priority === 'Alta' ? 'selected' : ''}>Alta</option>
                    </select>
                </td>
                <td> 
                    <input type="text" class="form-control form-control-sm update-field" 
                        data-field="connector" 
                        value="${escapeHtml(element.connector)}">
                </td>
                <td class="text-end"> 
                    <input type="number" class="form-control form-control-sm update-field" 
                        data-field="connectorQty" 
                        value="${element.connectorQty ?? 0}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm update-field" 
                        data-field="terminal" 
                        value="${escapeHtml(element.terminal)}">
                </td>
                <td class="text-end">
                    <input type="number" class="form-control form-control-sm update-field" 
                        data-field="terminalQty" 
                        value="${element.terminalQty ?? 0}">
                </td>
                <td>
                    <input type="date" 
                    class="form-control form-control-sm update-field" 
                    data-field="dateRecepcion" 
                    value="${formatDate(element.dateRecepcion)}">
                </td>
                <td>
                    <input type="date" class="form-control form-control-sm update-field" 
                    data-field="dateEntrega" 
                    value="${formatDate(element.dateEntrega)}">
                </td>
                <td>
                <input type="text" class="form-control form-control-sm update-field" data-field="status" value="${escapeHtml(element.status)}">
                </td>
                <td> <input type="text" class="form-control form-control-sm update-field" data-field="po" value="${escapeHtml(element.po)}"></td>
                <td>
                <input type="text" class="form-control form-control-sm update-field" data-field="observaciones" value="${escapeHtml(element.observaciones)}">
                </td>

                <td>
                <input type="text" class="form-control form-control-sm update-field" data-field="materialAtLaredo" value="${escapeHtml(element.materialAtLaredo)}"></td>
                <td>
                <input type="date" class="form-control form-control-sm update-field" data-field="eta_bea" value="${formatDate(element.eta_bea)}"></td>
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
}, 60000);

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('update-field')) {

        const input = e.target;
        const newValue = input.value;
        const field = input.dataset.field;
        const row = input.closest('tr');
        const id = row.dataset.id;

        updateField(id, field, newValue);
    }
});
function updateField(id, field, value) {
    const url = updatematerial;
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            id: id,
            field: field,
            value: value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert('Error updating');
        }
    })
    .catch(error => console.error(error));
}
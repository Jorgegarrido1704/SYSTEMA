
async function search() {
    const baseUrl = datas;
    const pns = document.getElementById('pns').value;
    const customer = document.getElementById('customer').value;
    const responsable = document.getElementById('responsable').value;
    const filter = document.getElementById('Filter').value;
    const size = document.getElementById('size').value;
    const Dateini = document.getElementById('DateIni').value;
    const DateFin = document.getElementById('DateEnd').value;

    const url = `${baseUrl}?pns=${encodeURIComponent(pns)}&customer=${encodeURIComponent(customer)}&responsable=${encodeURIComponent(responsable)}&filter=${encodeURIComponent(filter)}&size=${encodeURIComponent(size)}&Dateini=${encodeURIComponent(Dateini)}&DateFin=${encodeURIComponent(DateFin)}`;

    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        jsonData = data;
        renderTable(data);
    } catch (error) {
        console.error('Error:', error);
    }
}

function renderTable(data) {
    const tableBody = document.getElementById('table-body');
    tableBody.innerHTML = '';

    data.forEach(item => {
        if(item.MRP==null || item.MRP==''){ colorMrp="0,255,255,0.33";}else{ colorMrp="192,190,190,0.15"}
        if(item.receiptDate==null || item.receiptDate==''){ colorReceipt="0,255,255,0.33";}else{ colorReceipt="192,190,190,0.15"}
        if(item.commitmentDate==null || item.commitmentDate==''){ colorCommitment="0,255,255,0.33";}else{ colorCommitment="192,190,190,0.15"}
        if(item.CompletionDate==null || item.CompletionDate==''){ colorCompletion="0,255,255,0.33";}else{ colorCompletion="192,190,190,0.15"}
        if(item.documentsApproved==null || item.documentsApproved==''){ colorDocumentsApproved="0,255,255,0.33";}else{ colorDocumentsApproved="192,190,190,0.15"}
        if(item.customerDate==null || item.customerDate==''){ colorDueDate="0,255,255,0.33";}else{ colorDueDate="192,190,190,0.15"}


        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.pn}</td>
            <td>${item.customer}</td>
            <td><input type="number" id="qtyInPo${item.id}" value="${item.qtyInPo}"></td>
            <td style="background:${item.Color};">
            <select id="Color${item.id}" name="Color${item.id}">
            <option value="${item.Color}">Actual ${item.Color}</option>
            <option value="yellow">Yellow</option><option value="green">Green</option><option value="white">White</option></select>
            </td>
            <td><textarea id="WorkRev${item.id}" rows="2" cols="14">${item.WorkRev}</textarea></td>
            <td> <select id="size${item.id}" name="size${item.id}"> <option value="${item.size}">${item.size}</option>
                <option value="Ch">Ch </option><option value="M">M</option><option value="G">G</option></select></td>
            <td><select id="FullSize${item.id}" >
                <option value="${item.FullSize}">${item.FullSize}</option>
                <option value="SI">SI</option><option value="NO">NO</option></select>
            </td>
            <td style="background:rgba(${colorMrp});"><input type="date" id="MRP${item.id}" value="${item.MRP}"></td>
            <td style="background:rgba(${colorReceipt});"><input type="date" id="receiptDate${item.id}" value="${item.receiptDate}"></td>
            <td style="background:rgba(${colorCommitment});"><input type="date" id="commitmentDate${item.id}" value="${item.commitmentDate}"></td>
            <td style="background:rgba(${colorCompletion});"><input type="date" id="CompletionDate${item.id}" value="${item.CompletionDate}"></td>
            <td style="background:rgba(${colorDocumentsApproved});"><input type="date" id="documentsApproved${item.id}" value="${item.documentsApproved}"></td>
            <td>
            <select  id="Status${item.id}">
            <option value="${item.Status}">${item.Status}</option><option value="On Hold">On Hold</option><option value='CANCELLED'>CANCELLED</option>
            <option value="Pending">Pending</option><option value="Completed">Completed</option><option value= 'In Progress'>In Progress</option></select></td>
            <td><input type="text" id="responsable${item.id}" value="${item.resposible}"></td>
            <td style="background:rgba(${colorDueDate});"><input type="date" id="dueDate${item.id}" value="${item.customerDate}"></td>
            <td><textarea id="comments${item.id}" rows="2" cols="15">${item.comments || ''}</textarea></td>
            <td>
                <form id="form-${item.id}" method="GET" action="/editDelite" onsubmit="prepareEdit(${item.id})">
                    <input type="hidden" name="id_edit" value="${item.id}">
                    <input type="hidden" name="color" id="color${item.id}">
                    <input type="hidden" name="qip" id="qip${item.id}">
                    <input type="hidden" name="WR" id="WR${item.id}">
                    <input type="hidden" name="s" id="s${item.id}">
                    <input type="hidden" name="FS" id="FS${item.id}">
                    <input type="hidden" name="MRP" id="MRP_H${item.id}">
                    <input type="hidden" name="receiptDate" id="receiptDate_H${item.id}">
                    <input type="hidden" name="commitmentDate" id="commitmentDate_H${item.id}">
                    <input type="hidden" name="CompletionDate" id="CompletionDate_H${item.id}">
                    <input type="hidden" name="documentsApproved" id="documentsApproved_H${item.id}">
                    <input type="hidden" name="Status" id="Status_H${item.id}">
                    <input type="hidden" name="resposible" id="responsable_H${item.id}">
                    <input type="hidden" name="customerDate_" id="customerDate_H${item.id}">
                    <input type="hidden" name="comments_" id="comments_H${item.id}">
                    <button class="btn btn-success">Edit</button>
                </form>
            </td>
            <td>
                <form method="GET" action="/editDelite">
                    <input type="hidden" name="id_delete" value="${item.id}">
                    <button class="btn btn-danger">Delete</button>
                </form>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

function prepareEdit(id) {
    document.getElementById(`WR${id}`).value = document.getElementById(`WorkRev${id}`).value;
    document.getElementById(`s${id}`).value = document.getElementById(`size${id}`).value;
    document.getElementById(`color${id}`).value = document.getElementById(`Color${id}`).value;
    document.getElementById(`qip${id}`).value = document.getElementById(`qtyInPo${id}`).value;
    document.getElementById(`FS${id}`).value = document.getElementById(`FullSize${id}`).value;
    document.getElementById(`MRP_H${id}`).value = document.getElementById(`MRP${id}`).value;
    document.getElementById(`receiptDate_H${id}`).value = document.getElementById(`receiptDate${id}`).value;
    document.getElementById(`commitmentDate_H${id}`).value = document.getElementById(`commitmentDate${id}`).value;
    document.getElementById(`CompletionDate_H${id}`).value = document.getElementById(`CompletionDate${id}`).value;
    document.getElementById(`documentsApproved_H${id}`).value = document.getElementById(`documentsApproved${id}`).value;
    document.getElementById(`Status_H${id}`).value = document.getElementById(`Status${id}`).value;
    document.getElementById(`responsable_H${id}`).value = document.getElementById(`responsable${id}`).value;
    document.getElementById(`customerDate_H${id}`).value = document.getElementById(`dueDate${id}`).value;
    document.getElementById(`comments_H${id}`).value = document.getElementById(`comments${id}`).value;
}

function addworks() {
    const formularioDiv = document.getElementById('formularioRegistro');
    formularioDiv.style.display = formularioDiv.style.display === 'block' ? 'none' : 'block';
}



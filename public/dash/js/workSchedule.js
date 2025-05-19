async function search() {
    const baseUrl = datas;
    const pns = document.getElementById('pns').value ;
    const customer = document.getElementById('customer').value;
    const responsable = document.getElementById('responsable').value;
    const filter = document.getElementById('Filter').value ;
    const size = document.getElementById('size').value ;
    const Dateini = document.getElementById('DateIni').value;
    const DateFin = document.getElementById('DateEnd').value;

    console.log(DateFin + ' ' + Dateini+ ' ' + size + ' ' + filter + ' ' + responsable + ' ' + customer + ' ' + pns);
    const url = `${baseUrl}?pns=${encodeURIComponent(pns)}&customer=${encodeURIComponent(customer)}&responsable=${encodeURIComponent(responsable)}&filter=${encodeURIComponent(filter)}&size=${encodeURIComponent(size)}&Dateini=${encodeURIComponent(Dateini)}&DateFin=${encodeURIComponent(DateFin)}`;

    try {
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        jsonData = data;
        renderTable(data);
        console.log(jsonData);
    } catch (error) {
        console.error('Error:', error);
    }
}



    function renderTable(data) {
        const tableBody = document.getElementById('table-body');
        tableBody.innerHTML = ''; // Clear previous results

        data.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
            <form id="form-${item.id} " method="GET" action="#">
            <td style="width: 90px;">${item.pn}</td>
            <td style="width: 90px;">${item.customer}</td>
            <td style="width: 110px;"><textarea name="WorkRev" value="${item.WorkRev}"  rows="2" cols="15" style="width: 110px;">${item.WorkRev}</textarea></td>
            <td style="width: 70px;"><input type="text" name="size" value="${item.size}" style="width: 70px;"></td>
            <td style="width: 80px;"><input type="text" name="FullSize" value="${item.FullSize}" style="width: 80px;"></td>
            <td style="width: 120px;"><input type="text" name="MRP" value="${item.MRP}" style="width: 120px;"></td>
            <td style="width: 120px;"><input type="text" name="receiptDate" value="${item.receiptDate}" style="width: 120px;"></td>
            <td style="width: 120px;"><input type="text" name="commitmentDate" value="${item.commitmentDate}" style="width: 120px;"></td>
            <td style="width: 120px;"><input type="text" name="CompletionDate" value="${item.CompletionDate}" style="width: 120px;"></td>
            <td style="width: 120px;"><input type="text" name="documentsApproved" value="${item.documentsApproved}" style="width: 120px;"></td>
            <td style="width: 75px;"><input type="text" name="Status" value="${item.Status}" style="width: 75px;"></td>
            <td style="width: 90px;"><input type="text" name="resposible" value="${item.resposible}" style="width: 90px;"></td>
            <td style="width: 120px;"><input type="text" name="customerDate" value="${item.customerDate}" style="width: 120px;"></td>
            <td style="width: 90px;"><textarea name="comments" rows="2" cols="15" style="width: 90px;" ></textarea></td>
            <td style="width: 90px;">
            <input type="hidden" name="id" value="${item.id}">
            <button class="btn btn-success">Edit</button></td>
            </form><form id="form-${item.id} " method="POST" action="../datos/delete.php">
            <td>
            <input type="hidden" name="id" value="${item.id}">
            <button class="btn btn-danger">Delete</button></td>
            </form>
        `;
            tableBody.appendChild(row);
        });
    }


    function addworks(){
       let formularioDiv= document.getElementById('formularioRegistro');
       if(formularioDiv.style.display == 'block'){
        formularioDiv.style.display = 'none';
       }else{
       formularioDiv.style.display = 'block';}
    }

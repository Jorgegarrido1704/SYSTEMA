async function search() {
    const baseUrl = datas;
    const pns = document.getElementById('pns').value;
    const url = `${baseUrl}?pns=${encodeURIComponent(pns)}`;

    try {
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        jsonData = data;
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
            <form id="form-${item.id} " method="POST" action="../datos/update.php">
            <td>${item.pn}</td>
            <td>${item.customer}</td>
            <td><input type="text" name="WorkRev" value="${item.WorkRev}" style="width: 90px;"> <br>${item.WorkRev}</td>
            <td><input type="text" name="size" value="${item.size}" style="width: 35px;">${item.size}</td>
            <td><input type="text" name="FullSize" value="${item.FullSize}" style="width: 65px;">${item.FullSize}</td>
            <td><input type="text" name="MRP" value="${item.MRP}" style="width: 90px;">${item.MRP}</td>
            <td><input type="text" name="receiptDate" value="${item.receiptDate}" style="width: 90px;">${item.receiptDate}</td>
            <td><input type="text" name="commitmentDate" value="${item.commitmentDate}" style="width: 90px;">${item.commitmentDate}</td>
            <td><input type="text" name="CompletionDate" value="${item.CompletionDate}" style="width: 90px;">${item.CompletionDate}</td>
            <td><input type="text" name="documentsApproved" value="${item.documentsApproved}" style="width: 90px;">${item.documentsApproved}</td>
            <td><input type="text" name="Status" value="${item.Status}" style="width: 90px;">${item.Status}</td>
            <td><input type="text" name="resposible" value="${item.resposible}" style="width: 90px;">${item.resposible}</td>
            <td><input type="text" name="customerDate" value="${item.customerDate}" style="width: 90px;">${item.customerDate}</td>
            <td><textarea name="comments" rows="4" cols="50" style="width: 90px;" ></textarea></td>
            <td>
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


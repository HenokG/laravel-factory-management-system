function displayTable(packages) {
    for (var i = 0; i < packages.length; i++) {
        var shouldAppend = getHeader(packages[i].name);
        $('#myTable > tbody:last-child').append(shouldAppend);
        $('#myTable tr:last').after(getDatas(packages[i]));
        $("#sendToSystem").removeClass("invisible");
    }
}

function getHeader(name) {
    var header = '<thead>' +
        '  <tr class="bg-light">' +
        '    <th scope="col">' + name + '</th>' +
        '    <th scope="col">Length</th>' +
        '    <th scope="col">Width</th>' +
        '    <th scope="col">Thick</th>' +
        '    <th scope="col">Pcs</th>' +
        '    <th scope="col">Ml</th>' +
        '    <th scope="col">M2</th>' +
        '    <th scope="col">Unit price</th>' +
        '    <th scope="col">Amount</th>' +
        '    <th scope="col">Remark</th>' +
        '  </tr>' +
        '</thead>';
    return header;
}

function getDatas(package) {
    package_data = package.data;

    var m1 = 0;
    var m2 = 0;
    var table = '';
    var total_amount = 0;
    for (var i = 0; i < package_data.length; i++) {
        package_data[i]
        var str = package_data[i][5];//.toLowerCase();
        //var list=str.split("&");
        if (str != "") {
            m1 += package_data[i][1] * package_data[i][4];
        }

        m2 += package_data[i][1] * package_data[i][2] * package_data[i][4]


        table +=
            '<tr>' +
            '  <th scope="row">' + package_data[i][0] + '</th>' +
            '  <td>' + package_data[i][1] + '</td>' +
            '  <td>' + package_data[i][2] + '</td>' +
            '  <td>' + package_data[i][3] + '</td>' +
            '  <td>' + package_data[i][4] + '</td>' +
            '  <td>' + (package_data[i][1] * package_data[i][4]).toFixed(2) + '</td>' +
            '  <td>' + (package_data[i][1] * package_data[i][2] * package_data[i][4]).toFixed(2) + '</td>' +
            '  <td></td>' +
            '  <td></td>' +
            '  <td>' + package_data[i][5] + '</td>' +
            '</tr>';
    }

    if (package.hasOwnProperty('Bullnose')) {
        total_amount += m1 * package.Bullnose
        table += getAdditional('Bullnose', m1, package.Bullnose);
    }
    if (package.hasOwnProperty('bullnose')) {
        total_amount += m1 * package.bullnose
        table += getAdditional('bullnose', m1, package.bullnose);
    }
    if (package.hasOwnProperty('Groove')) {
        total_amount += m1 * package.Groove
        table += getAdditional('Groove', m1, package.Groove);
    }
    if (package.hasOwnProperty('groove')) {
        total_amount += m1 * package.groove
        table += getAdditional('groove', m1, package.groove);
    }

    if (package.hasOwnProperty('M2')) {
        m2price = package.M2
    } else if (package.hasOwnProperty('m2')) {
        m2price = package.m2
    }

    var amount = m2 * m2price;
    total_amount += amount;

    table +=
        'tr>' +
        '  <th scope="row">M2</th>' +
        '  <td></td>' +
        '  <td></td>' +
        '  <td></td>' +
        '  <td></td>' +
        '  <td></td>' +
        '  <td>' + m2.toFixed(2) + '</td>' +
        '  <td>' + m2price.toFixed(2) + '</td>' +
        '  <td>' + amount.toFixed(2) + '</td>' +
        '  <td></td>' +
        '</tr>';


    table += '<tr class="">' +
        '<th scope="row">Subtotal</th>' +
        '<td></td>' +
        '<td></td>' +
        '<td></td>' +
        '<td></td>' +
        '<td></td>' +
        '<td></td>' +
        '<td></td>' +
        '<td>' + total_amount.toFixed(2) + '</td>' +
        '<td></td>' +
        '</tr>'

    return table;

}

function getAdditional(name, ml, unitprice) {
    var d = '<tr>' +
        '  <th scope="row">' + name + '</th>' +
        '  <td></td>' +
        '  <td></td>' +
        '  <td></td>' +
        '  <td></td>' +
        '  <td>' + ml.toFixed(2) + '</td>' +
        '  <td></td>' +
        '  <td>' + unitprice.toFixed(2) + '</td>' +
        '  <td>' + (ml * unitprice).toFixed(2) + '</td>' +
        '  <td></td>' +
        '</tr>'
    return d;
}
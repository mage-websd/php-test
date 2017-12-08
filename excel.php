<table id="tbl1" class="table2excel">
        <tr>
            <td>Product</td>
            <td>Price</td>
            <td>Available</td>
            <td>Count</td>
        </tr>
        <tr>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
        </tr>
        <tr>
            <td>Bred</td>
            <td>1</td>
            <td>2</td>
             <td>3</td>
        </tr>
        <tr>
            <td>Butter</td>
            <td>4   </td>
            <td>5   </td>
            <td >6  </td>
        </tr>
  </table>
<hr>

  <table id="tbl2" class="table2excel">
        <tr>
            <td>Product</td>
            <td>Price</td>
            <td>Available</td>
            <td>Count</td>
        </tr>
        <tr>
            <td>Bred</td>
            <td>7</td>
            <td>8</td>
            <td>9</td>
        </tr>
        <tr>
            <td>Butter</td>
            <td>14</td>
            <td>15</td>
            <td >16</td>
        </tr>
    </table>


<button  onclick="tablesToExcel(['tbl1','tbl2'], ['ProductDay1','ProductDay2'], 'TestBook.xls', 'Excel')">Export to Excel</button>

<script src="https://cdn.rawgit.com/eligrey/Blob.js/0cef2746414269b16834878a8abc52eb9d53e6bd/Blob.js"></script>
    <script src="https://cdn.rawgit.com/eligrey/canvas-toBlob.js/f1a01896135ab378aa5c0118eadd81da55e698d8/canvas-toBlob.js"></script>
    <script src="https://cdn.rawgit.com/eligrey/FileSaver.js/e9d941381475b5df8b7d7691013401e171014e89/FileSaver.min.js"></script>

<script type="text/javascript">
var tablesToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;charset=utf-8;base64,'
    , tmplWorkbookXML = '<?xml version="1.0"?><?mso-application progid="Excel.Sheet"?><Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">'
      + '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office"><Author>Axel Richter</Author><Created>{created}</Created></DocumentProperties>'
      + '<Styles>'
    + '<Style ss:ID="Box1">'
      +'<Alignment ss:Vertical="Bottom"/>'
      +'<Font ss:Size="18" ss:Color="#a92727"/>' // ss:FontName="Calibri" x:Family="Swiss"
      +'<Interior ss:Color="#800080" ss:Pattern="Solid"/>' //background
      +'<NumberFormat/>'
      +'<Protection/>'
      + '<Borders>'
         + '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>'
         + '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>'
         + '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>'
         + '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>'
      + '</Borders>'
        + '</Style>'
      + '<Style ss:ID="Currency"><NumberFormat ss:Format="Currency"></NumberFormat></Style>'
      + '<Style ss:ID="Date"><NumberFormat ss:Format="Medium Date"></NumberFormat></Style>'
      + '</Styles>' 
      + '{worksheets}</Workbook>'
    , tmplWorksheetXML = '<Worksheet ss:Name="{nameWS}"><Table><Column ss:AutoFitWidth="0" ss:Width="300"/>{rows}</Table></Worksheet>'
    , tmplCellXML = '<Cell{attributeStyleID}{attributeFormula}><Data ss:Type="{nameType}">{data}</Data></Cell>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    return function(tables, wsnames, wbname, appname) {
      var ctx = "";
      var workbookXML = "";
      var worksheetsXML = "";
      var rowsXML = "";

      for (var i = 0; i < tables.length; i++) {
        if (!tables[i].nodeType) tables[i] = document.getElementById(tables[i]);
        for (var j = 0; j < tables[i].rows.length; j++) {
          rowsXML += '<Row ss:AutoFitHeight="0" ss:Height="100">' // fix height for row, or null
          for (var k = 0; k < tables[i].rows[j].cells.length; k++) {
            var dataType = tables[i].rows[j].cells[k].getAttribute("data-type");
            var dataStyle = tables[i].rows[j].cells[k].getAttribute("data-style");
            var dataValue = tables[i].rows[j].cells[k].getAttribute("data-value");
            dataValue = (dataValue)?dataValue:tables[i].rows[j].cells[k].innerHTML;
            var dataFormula = tables[i].rows[j].cells[k].getAttribute("data-formula");
            dataFormula = (dataFormula)?dataFormula:(appname=='Calc' && dataType=='DateTime')?dataValue:null;
            ctx = {  attributeStyleID: (dataStyle=='Currency' || dataStyle=='Date')?' ss:StyleID="'+dataStyle+'"':' ss:StyleID="Box1"'
                   , nameType: (dataType=='Number' || dataType=='DateTime' || dataType=='Boolean' || dataType=='Error')?dataType:'String'
                   , data: (dataFormula)?'':dataValue
                   , attributeFormula: (dataFormula)?' ss:Formula="'+dataFormula+'"':''
                  };
            rowsXML += format(tmplCellXML, ctx);
          }
          rowsXML += '</Row>'
        }
        ctx = {rows: rowsXML, nameWS: wsnames[i] || 'Sheet' + i};
        worksheetsXML += format(tmplWorksheetXML, ctx);
        rowsXML = "";
      }

      ctx = {created: (new Date()).getTime(), worksheets: worksheetsXML};
      workbookXML = format(tmplWorkbookXML, ctx);


      /*
      var link = document.createElement("a");
      link.href = uri + base64(workbookXML);
      link.download = wbname || 'Workbook.xls';
      link.target = '_blank';
      link.id='downlod-export-excel';
      document.body.appendChild(link);
      //$("#downlod-export-excel").downloadify( options );
      link.click();
      document.body.removeChild(link);
      */
      var blob = new Blob([workbookXML], {type: "application/vnd.ms-excel;charset=utf-8"});
      saveAs(blob, wbname);

      // var blob = new Blob([base64(workbookXML)], {type: "application/vnd.ms-excel"});
      //           window.URL = window.URL || window.webkitURL;
      //           link = window.URL.createObjectURL(blob);
      //           a = document.createElement("a");
      //           a.download = 'abc.xlsx';//getFileName(e.settings);
      //           a.href = link;

      //           document.body.appendChild(a);

      //           a.click();

      //           document.body.removeChild(a);
    }
  })();
  var blob = new Blob(["Hello, world!"], {type: "text/plain;charset=utf-8"});
saveAs(blob, "hello world.txt");
</script>


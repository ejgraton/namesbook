<html>
<body>
Hello!<br>
<link rel="stylesheet" media="screen" href="omnigrid/omnigrid.css" type="text/css" />
<script type="text/javascript" src="mootools/mootools-core-1.6.0.js"></script>
<script type="text/javascript" src="mootools/mootools-more-1.6.0.js"></script>
<script type="text/javascript" src="omnigrid/omnigrid.js"></script>

<script type="text/javascript">

    function onGridSelect(evt)
    {
         var str = 'row: '+evt.row+' indices: '+evt.indices;
/*
         str += ' id: '+evt.target.getDataByRow(evt.row).id;

         evt.target.editable = true;
         alert( str );
*/
    }

//at omnigrid.js        this.options.accordionRenderer({parent:li2, row:r, grid:this, rowdata: rowdata});
    function accordionFcn(data)
    {
       var detail = data.rowdata.detail;
       var n_contacts = detail.length;       
       var li;
       var iDiv;
      
       for(i=0; i<n_contacts; i++) {
         li = document.createElement('li');   
         li.id = 'details-' + data.rowdata.nick;
         li.className = 'tr';

         //type, contact
         for(j=0; j<2; j++) {
           iDiv = document.createElement('div');
           iDiv.id = 'detail-' + j;
           iDiv.className = 'td';
           iDiv.style.width = "40%";
           iDiv.style.height = "20px";
           switch(j) {
             case 0: iDiv.innerHTML = detail[i].type;
             break;
             case 1: iDiv.innerHTML = detail[i].contact;
             break;
           } 
           li.appendChild(iDiv);
         }
         data.parent.appendChild(li);
       }

       n_contacts *= 20;
       data.parent.style.height = n_contacts.toString() + "px";
    }

//    function gridButtonClick(button, grid)
    function gridButtonClick(evt)
    {
         alert(evt.target.className);
         switch(evt.target.className) {
             case 'add':
             break;
             case 'delete':
             break;
             case 'duplicate':
             break;
         }
    }

    var cmu = [
            {
               header: "Nick",
               dataIndex: 'nick',
               dataType:'string',
               editable: true
            },
            {
               header: "email",
               dataIndex: 'email',
               dataType:'string',
               width:200
            }]; 

    window.addEvent("domready", function(){

        datagrid = new omniGrid('mygrid', {
            columnModel: cmu,
            buttons : [
              {name: 'Add', bclass: 'add', onclick : gridButtonClick},
              {name: 'Delete', bclass: 'delete', onclick : gridButtonClick},
              {separator: true},
              {name: 'Duplicate', bclass: 'duplicate', onclick : gridButtonClick}
            ],
            url:"api/jobeval.php",
            perPageOptions: [10,20,50,100,200],
            perPage:10,
            page:1,
            editable:true,
            editondblclick:true,
            pagination:true,
            serverSort:true,
            showHeader: true,
            alternaterows: true,
            sortHeader:false,
            resizeColumns:true,
//            multipleSelection:true,
            multipleSelection:false,

            // uncomment this if you want accordion behavior for every row
            
            accordion:true,
            accordionRenderer:accordionFcn, //accordionFunction,
            
            autoSectionToggle:false,
            //
            openAccordionOnDblClick:false,
            showtoggleicon:true,
            width:600,
            height: 400
        });

        datagrid.addEvent('click', onGridSelect);
        var bt = document.getElementsByClassName("add");
        if(bt) bt[0].addEventListener('click', gridButtonClick);
        bt = document.getElementsByClassName("delete");
        if(bt) bt[0].addEventListener('click', gridButtonClick);
        bt = document.getElementsByClassName("duplicate");
        if(bt) bt[0].addEventListener('click', gridButtonClick);
        

     });
</script>

<div id="mygrid" ></div>
</html>
</body>
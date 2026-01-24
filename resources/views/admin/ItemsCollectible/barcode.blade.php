<style >
    @page {
        size: 75mm 13mm;   /* auto is the initial value */
        margin: 0 ;
        padding: 0;


        /* this affects the margin in the printer settings */
    }

    body {

    width: 75mm;
    height: 13mm;
    margin: 0;
    padding: 0;
}
</style>


<body id="barcode_item" style="direction: rtl; width: 75mm ; margin-top: 0;
padding-left: 0 ; padding-right: 0;   margin-right: 0  ;">
<div class="row" style="width:45mm; display: flex ; " >

    <div class="col-6 text-center" style="width: 22.5mm; height: 13mm;  ">

        <img style="  width: 18mm; height: 8mm ; margin: 0 auto; display:block ; "
             src="https://barcode.tec-it.com/barcode.ashx?data={{$item['code']}}&code=Code128">
        <label style="  width: 18mm; font-size:10px ;height: 5mm ; margin: 0 auto; display:block ; text-align: center">{{$item -> karat -> label}}</label>
    </div>
    <div class="col-6 text-center" style="width: 22.5mm; height: 13mm;">

        <label style="  width: 20mm; height: 5mm ; margin: 0 auto; display:block ; text-align: center ">روائع الماسية</label>
        <label style="  width: 18mm; font-size:12px ;height: 8mm ; margin: 0 auto; display:block ; text-align: center">{{$item -> weight }} wt</label>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>


    $(document).ready(function (){ 
          window.print();
          window.onafterprint = function(){
   console.log("Printing completed...");
}
        
    });
    function printBarcode() {
        const originalHTML = document.body.innerHTML;
        document.body.innerHTML = document.getElementById('barcode_item').innerHTML;
        document.querySelectorAll('.not-print')
            .forEach(img => img.remove())
        window.print();


    }
</script>

</body>



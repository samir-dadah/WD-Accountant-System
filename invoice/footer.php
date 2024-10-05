<?php
// +------------------------------------------------------------------------+
// | PHP MR WEBSITE LIST  ( www.mrdev.xyz/weblist/)
// +------------------------------------------------------------------------+
// | PHP MR WEBSITE LIST IS NOT FREE SOFTWARE
// | If you have downloaded this software from a website other
// | than www.mrdev.xyz or if you have received
// | this software from someone who is not a representative of
// | MRDEV, you are involved in an illegal activity.
// | ---
// | In such case, please contact: support@mrdev.xyz
// +------------------------------------------------------------------------+
// | Developed by: MR DEV (www.mrdev.xyz) / support@mrdev.xyz
// | Copyright: (c) 2020-2021 MRDEV. All rights reserved.
// +------------------------------------------------------------------------+

?>


</div>
<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span> &copy; <?php echo $ver; ?></span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>



<!-- Bootstrap core JavaScript-->
<script src="<?php echo $base_url; ?>assets/js/jquery.min.js"></script>
<script src="<?php echo $base_url; ?>assets/js/popper.min.js"></script>
<script src="<?php echo $base_url; ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo $base_url; ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $base_url; ?>assets/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $base_url; ?>assets/js/fontawesome-iconpicker.js"></script>
<script src="<?php echo $base_url; ?>assets/js/summernote.js"></script>
<script src="<?php echo $base_url; ?>assets/js/parsley.js"></script>
<script src="<?php echo $base_url; ?>assets/js/i18n/ar.js"></script>
<script src="<?php echo $base_url; ?>assets/js/clipboard.min.js"></script>
<script src="<?php echo $base_url; ?>assets/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="<?php echo $base_url; ?>assets/js/main.js"></script>
<script src="<?php echo $base_url; ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $base_url; ?>class/qr/kjua-0.9.0.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('form').attr('autocomplete', 'chrome-off');
    $('form').attr('autocomplete', 'off');
    $('#dataTable').DataTable({

        "language": {
          "sProcessing": "جارٍ التحميل...",
          "sLengthMenu": "أظهر _MENU_ مدخلات",
          "sZeroRecords": "لم يعثر على أية سجلات",
          "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
          "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
          "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
          "sInfoPostFix": "",
          "sSearch": "ابحث:",
          "sUrl": "",
          "oPaginate": {
            "sFirst": "الأول",
            "sPrevious": "السابق",
            "sNext": "التالي",
            "sLast": "الأخير"
          }
        }
      }

    );
    $('.demo').iconpicker();

    $('.demo').on('iconpickerSelected', function(event) {
      /* */
      var iconvalue = event.iconpickerValue;
      $('#category_icon').val(iconvalue);
      $('#social_icon').val(iconvalue);

    });


    $('#confirm-delete').on('show.bs.modal', function(e) {
      $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
    var clipboard = new ClipboardJS('.MR_copy_clipboard');
    clipboard.on('success', function(e) {
      alert("تم النسخ");
    });
    clipboard.on('error', function(e) {
      alert("لم يتم النسخ خطأ");
    });

    $('textarea').summernote({

      tabsize: 2,
      height: 100


    });






  });
</script>



</body>

</html>
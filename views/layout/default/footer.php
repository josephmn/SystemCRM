<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<footer class="main-footer">
  <strong>Copyright &copy; 2021-<?php echo date("Y")?> <a href="https://www.mundoaltomayo.com">VERDUM PERÚ SAC</a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b>&nbsp;&nbsp;<?php echo version ?>
  </div>
</footer>
</div>
<!-- ./wrapper -->

<!-- BEGIN: Llamada a JS-->
<?php if (isset($_layoutParams['jsSp']) && count($_layoutParams['jsSp'])) : ?>
  <?php foreach ($_layoutParams['jsSp'] as $layoutjsSp) : ?>
    <script src="<?php echo  $layoutjsSp ?>" type="text/javascript"></script>
  <?php endforeach; ?>
<?php endif; ?>
<!-- END: Llamada a JS-->

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<script id="toast" name="toast">
</script>

<?php if (isset($_layoutParams['js']) && count($_layoutParams['js'])) : ?>
  <?php foreach ($_layoutParams['js'] as $layout) : ?>
    <script src="<?php echo  $layout ?>" type="text/javascript"></script>
  <?php endforeach; ?>
<?php endif; ?>

</body>

</html>
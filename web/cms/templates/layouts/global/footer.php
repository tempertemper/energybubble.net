  <footer role="contentinfo">

    <nav role="navigation">
      <?php
        perch_pages_navigation([
          'hide-extensions'=>true,
          'hide-default-doc'=>true,
          'levels'=>1,
        ]);
      ?>
    </nav>

    <p>Site designed and built by <a href="https://tempertemper.net">tempertemper Web Design</a></p>
    <small>Copyright &copy; <?php echo date('Y'); ?></small>
  </footer>

  <?php perch_get_javascript(); ?>

</body>
</html>
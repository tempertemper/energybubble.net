  </main>

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

    <p><small>&copy; energybubble <?php echo date('Y'); ?></small></p>
    <p><small>Site designed and built by <a href="https://tempertemper.net">tempertemper Web Design</a></small></p>

  </footer>

  <?php perch_get_javascript(); ?>

</body>
</html>
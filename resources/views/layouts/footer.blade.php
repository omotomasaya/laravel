<footer class="footer">
        <ul class="horizontal-list">
            <li class="horizontal-item"><a href="{{ route('equipmentProducts') }}">Equipment</a></li>
            <li class="horizontal-item"><a href="{{ route('foodProducts') }}">Food</a></li>
            <li class="horizontal-item"><a href="{{ route('supplementProducts') }}">Supplement</a></li>
        </ul>       
        <p class="copyright">Copyright © 2021 筋SHOP Inc. All rights reserved.</p>
    </footer>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.0/masonry.pkgd.js"></script>
  <script>
    window.onload = function(){
      new Masonry('.product-wrapper', {
        itemSelector: '.product-box',
        columnWidth: 270,
        gutter: 4
      });
    };
  </script>
</body>
</html>
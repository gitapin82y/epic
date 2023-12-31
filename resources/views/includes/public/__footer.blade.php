@if (Auth::check())
<div id="livechat">
  <a href="{{ url("chat") }}" class="btn-livechat"
    ><img src="{{asset('assets/public/img/icon-livechat.png')}}" alt="" /> Live Chat</a
  >
</div>
@endif

<footer>
  <div class="container pt-3 pt-md-5">
    <div class="row col-12">
      <div class="col-12 col-md-3 mt-4 mt-md-0">
        <img src="{{asset('assets/public/img/logo.png')}}" class="mb-4" width="80px" alt="" />
        <p>Ajukan perizinan secara mandiri dengan sistem daring (online).</p>
        <small>Copyright 2023 By Epic - All Rights Reserved.</small>
      </div>
      <div class="col-12 col-md-3 mt-4 mt-md-0">
        <h3>Sosial Media</h3>
        <ul>
          <li>
            <a href="https://www.instagram.com/epic.smartcity?igsh=ZmE2OGw0bjI5NjF5&utm_source=qr" class="text-dark">Instagram</a>
          </li>

          <li>
            <a href="https://www.linkedin.com/in/urbanifycompany/" class="text-dark">LinkedIn</a>
          </li>

          <li>
            <a href="https://twitter.com/epicurbanify" class="text-dark">Twitter</a>
          </li>

          <li>
            <a href="https://www.youtube.com/channel/UC_cKinCVMkjnOY3H1LwHacA" class="text-dark">Youtube</a>
          </li>
        </ul>
      </div>
      <div class="col-12 col-md-3 mt-4 mt-md-0">
        <h3>Contact Us</h3>
        <ul>
          <li>(031) 8112312234</li>
          <li>epic@gmail.com</li>
        </ul>
      </div>
      <div class="col-12 col-md-3 mt-4 mt-md-0">
        <h3>Alamat</h3>
        <p>
          Jl Kenari No 57, Kec Jambangan, Kota Surabaya, Jawa Timur 60234
        </p>
      </div>
    </div>
  </div>
</footer>
<link
      rel="shortcut icon"
      href="{{asset('assets/public/img/favicon.ico')}}"
      type="image/x-icon"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap"
      rel="stylesheet"
    />

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    />

    <link rel="stylesheet" href="{{asset('assets/public/style.css')}}" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
      #showDropdown:hover {
      cursor: pointer;
    }
    img.avatar {
      width: 48px;
      height: 48px;
      border-radius: 48px;
    }
    
    .dropdown {
      cursor: pointer;
          position: relative;
          display: inline-block;
        }
    
    .dropdown .dropdown-content {
          display: none;
          position: absolute;
          background-color: #ffffff;
          box-shadow: 0 8px 20px rgba(90, 90, 90, 0.1);
          z-index: 1;
          border-radius: 10px;
          text-align: left;
          padding: 10px 0px;
    
        }
    
        /* Style item dropdown */
        .dropdown .dropdown-content a {
          color: black;
          padding: 12px 30px;
          display: block;
          text-decoration: none;
        }
    
        /* Style item dropdown saat dihover */
        .dropdown .dropdown-content a:hover {
          background-color: #499db1;
        }
    
        /* Tampilkan dropdown content saat menu dihover */
        .dropdown:hover .dropdown-content {
          display: block;
        }
    </style>
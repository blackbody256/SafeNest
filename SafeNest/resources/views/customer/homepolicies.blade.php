<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Policies for You</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
      outline: none;
      border: none;
      text-decoration: none;
    }

    :root {
      --pink: #e84393;
      --header-height: 70px;
    }

    html {
      font-size: 62.5%;
      scroll-behavior: smooth;
      scroll-padding-top: var(--header-height);
      overflow-x: hidden;
    }

    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      background: #f9f9f9;
    }

    header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: var(--header-height);
      background: #fff;
      padding: 0 5%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      z-index: 1000;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    header .logo {
      font-size: 2.5rem;
      color: #333;
      font-weight: bolder;
    }

    header .logo span {
      color: var(--pink);
    }

    header .navbar a {
      font-size: 1.6rem;
      padding: 0 1rem;
      color: #666;
      transition: 0.3s;
    }

    header .navbar a:hover {
      color: var(--pink);
    }

    .container {
      flex: 1;
      padding: calc(var(--header-height) + 2rem) 5% 2rem 5%;
    }

    h1 {
      color: var(--pink);
      text-align: center;
      margin-bottom: 2rem;
      font-size: 3rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 2rem;
      background: #fff;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
      border-radius: 1rem;
      overflow: hidden;
    }

    th, td {
      padding: 1.5rem;
      text-align: left;
      font-size: 1.4rem;
    }

    th {
      background-color: var(--pink);
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    tr:hover {
      background-color: #ffe0ef;
    }

    .no-policies {
      text-align: center;
      margin-top: 4rem;
      font-size: 1.6rem;
      color: #555;
    }

    footer {
      background: #333;
      color: #fff;
      text-align: center;
      padding: 1.5rem 0;
      font-size: 1.3rem;
    }

    /* Responsive tweaks */
    @media (max-width: 768px) {
      header {
        padding: 0 2rem;
      }
      .container {
        padding: calc(var(--header-height) + 1rem) 2rem 2rem 2rem;
      }
    }
  </style>
</head>
<body>

<!-- Header Section -->
<header>
  <a href="#" class="logo">SafeNest<span>.</span></a>
  <nav class="navbar">
    <a href="{{ url('/') }}#home">Home</a>
    <a href="{{ url('/') }}#about">About</a>
    <a href="{{ url('/') }}#contact">Contact</a>
    <a href="{{ route('login') }}" class="nav-link nav-item {{ Route::is('login') ? 'active' : '' }}">
      Login
    </a>
  </nav>
</header>

<!-- Main Content -->
<div class="container">
  <h1>Available Policies</h1>

  @if($policies->isEmpty())
    <div class="no-policies">
      No policies available at the moment.
    </div>
  @else
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Premium</th>
          <th>Duration (years)</th>
        </tr>
      </thead>
      <tbody>
        @foreach($policies as $policy)
          <tr>
            <td>{{ $policy->Title }}</td>
            <td>{{ $policy->Description }}</td>
            <td>{{ $policy->Premium }}</td>
            <td>{{ $policy->Duration }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>

<!-- Footer -->
<footer>
  © 2025 SafeNest. All rights reserved.
</footer>

</body>
</html>

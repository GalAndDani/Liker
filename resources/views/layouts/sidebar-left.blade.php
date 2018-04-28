<!-- Newsfeed Common Side Bar Left
          ================================================= -->

<div class="profile-card">
    <img src="{{ Auth::user()->picture ?: asset('images/users/user-1.jpg') }}" alt="user" class="profile-photo"/>
    <h5 class="text-white">{{ Auth::user() ? ucfirst(\Illuminate\Support\Facades\Auth::user()->first_name) . ' ' . ucfirst(\Illuminate\Support\Facades\Auth::user()->last_name) : 'Hello Guest' }}
        <span class="pull-right"><a href="{{ route('page.profile') }}" class="text-white"><i class="fas fa-pen-square"></i></a></span>
    </h5>
    <span class="text-white"><b>{{ Auth::user() ? \Illuminate\Support\Facades\Auth::user()->points : 'Offline'}} Points</b></span>
</div><!--profile card ends-->

<ul class="nav-news-feed">
    <li><i class="fas fa-home"></i>
        <div><a href="{{ route('dashboard') }}">Dashboard</a></div>
    </li>
    <li><i class="fas fa-file-alt"></i>
        <div><a href="{{ route('page.show') }}">My Pages</a></div>
    </li>
    <li><i class="fas fa-plus-square"></i>
        <div><a href="{{ route('page.add') }}">Add New Page</a></div>
    </li>
    <li><i class="fas fa-users"></i>
        <div><a href="{{ route('page.referral') }}">My Referral</a></div>
    </li>
</ul><!--news-feed links ends-->
<ul class="nav-news-feed">
    <div class="header">Get Points</div>
    <li><i class="fas fa-star"></i>
        <div><a href="#">Daily Reward</a></div>
    </li>
    <li><i class="fas fa-star"></i>
        <div><a href="#">Buy Points</a></div>
    </li>
</ul><!--news-feed links ends-->
<ul class="nav-news-feed">
    <div class="header">Earn Free Points</div>
    <li><i class="fab fa-facebook-f"></i>
        <div><a href="{{ route('facebook.photo.likes') }}">Facebook Photos Likes</a></div>
    </li>
    <li><i class="fab fa-facebook-f"></i>
        <div><a href="{{ route('facebook.photo.shares') }}">Facebook Photos Shares</a></div>
    </li>
    <li><i class="fab fa-facebook-f"></i>
        <div><a href="{{ route('facebook.post.likes') }}">Facebook Posts Likes</a></div>
    </li>
    <li><i class="fab fa-facebook-f"></i>
        <div><a href="{{ route('facebook.post.shares') }}">Facebook Posts Shares</a></div>
    </li>
    <li><i class="fab fa-instagram"></i>
        <div><a href="#">Instagram Likes</a></div>
    </li>
    <li><i class="fab fa-instagram"></i>
        <div><a href="#">Instagram Followers</a></div>
    </li>
</ul><!--news-feed links ends-->

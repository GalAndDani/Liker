
<div id="chat-block">
    <div class="title">Chat online</div>
    <ul class="online-users list-inline">
        <li><a href="newsfeed-messages.html" title="Linda Lohan"><img src="{{ asset('images/users/user-2.jpg') }}"
                                                                      alt="user"
                                                                      class="img-responsive profile-photo"/><span
                        class="online-dot"></span></a></li>
        <li><a href="newsfeed-messages.html" title="Sophia Lee"><img src="{{ asset('images/users/user-3.jpg') }}"
                                                                     alt="user"
                                                                     class="img-responsive profile-photo"/><span
                        class="online-dot"></span></a></li>
        <li><a href="newsfeed-messages.html" title="John Doe"><img src="{{ asset('images/users/user-4.jpg') }}"
                                                                   alt="user"
                                                                   class="img-responsive profile-photo"/><span
                        class="online-dot"></span></a></li>
        <li><a href="newsfeed-messages.html" title="Alexis Clark"><img src="{{ asset('images/users/user-5.jpg') }}"
                                                                       alt="user"
                                                                       class="img-responsive profile-photo"/><span
                        class="online-dot"></span></a></li>
        <li><a href="newsfeed-messages.html" title="James Carter"><img src="{{ asset('images/users/user-6.jpg') }}"
                                                                       alt="user"
                                                                       class="img-responsive profile-photo"/><span
                        class="online-dot"></span></a></li>
        <li><a href="newsfeed-messages.html" title="Robert Cook"><img src="{{ asset('images/users/user-7.jpg') }}"
                                                                      alt="user"
                                                                      class="img-responsive profile-photo"/><span
                        class="online-dot"></span></a></li>
        <li><a href="newsfeed-messages.html" title="Richard Bell"><img src="{{ asset('images/users/user-8.jpg') }}"
                                                                       alt="user"
                                                                       class="img-responsive profile-photo"/><span
                        class="online-dot"></span></a></li>
        <li><a href="newsfeed-messages.html" title="Anna Young"><img src="{{ asset('images/users/user-9.jpg') }}"
                                                                     alt="user"
                                                                     class="img-responsive profile-photo"/><span
                        class="online-dot"></span></a></li>
        <li><a href="newsfeed-messages.html" title="Julia Cox"><img src="{{ asset('images/users/user-10.jpg') }}"
                                                                    alt="user"
                                                                    class="img-responsive profile-photo"/><span
                        class="online-dot"></span></a></li>
    </ul>
</div><!--chat block ends-->
<div class="referral">
    <h3 class="text-white">Affiliate Prorgam</h3>
    <p>Earn <b style="color: #8dc63f">300 points</b> for each valid registered friend. Check your referral url:</p>
    <input type="text" class="form-control" value="{{ Auth::user() ? route('welcome') . '/ref/' . Auth::user()->ref_id : 'Please Login'}}">
</div>

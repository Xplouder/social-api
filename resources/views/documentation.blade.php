<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>API Reference</title>

    <link rel="stylesheet" href="css/style.css" />
    <script src="js/all.js"></script>


    <script>
        $(function() {
            setupLanguages(["bash","javascript"]);
        });
    </script>
</head>

<body class="">
<a href="#" id="nav-button">
      <span>
        NAV
        <img src="images/navbar.png" />
      </span>
</a>
<div class="tocify-wrapper">
    <img src="images/logo.png" />
    <div class="lang-selector">
        <a href="#" data-language-name="bash">bash</a>
        <a href="#" data-language-name="javascript">javascript</a>
    </div>
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>
    <ul class="search-results"></ul>
    <div id="toc">
    </div>
    <ul class="toc-footer">
        <li><a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a></li>
    </ul>
</div>
<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <!-- START_INFO -->
        <h1>Info</h1>
        <h2>Thing Pink's Challenge API</h2>
        <p>API for a Social Application</p>
        <p><strong>Note:</strong> Use <code>perPage</code> and <code>page</code> parameters to control the pagination.</p>
        <!-- END_INFO -->
        <h1>general</h1>
        <!-- START_23c93a28f85a61981c10370dac908b7c -->
        <h2>Global Feed</h2>
        <p>Return the posts based on authentication state and friends.
            If the user is anonymous he will get the most recent public posts, if he is authenticated he will
            get most recent public, friends and own posts.</p>
        <p><code>GET https://example.com/api/v1/feed</code></p>
        <aside class="notice">
            <b>Optional</b>: You can add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
        </aside>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl "http://localhost/api/v1/feed" \
-H "Accept: application/json"</code></pre>
        <pre><code class="language-javascript">var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/v1/feed",
    "method": "GET",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});</code></pre>
        <blockquote>
            <p>Example response:</p>
        </blockquote>
        <pre><code class="language-json">{
  "total": 4,
  "per_page": 15,
  "current_page": 1,
  "last_page": 1,
  "next_page_url": null,
  "prev_page_url": null,
  "from": 1,
  "to": 4,
  "data": [
    {
      "id": 5,
      "user_id": 3,
      "body_text": "nopasdasdasd",
      "body_image": "4067dba6ff337b6645e6f13ba430e1b6.png",
      "public": "yes",
      "created_at": "2016-11-13 22:49:54",
      "updated_at": "2016-11-13 22:49:54",
      "deleted_at": null
    },
    {
      "id": 2,
      "user_id": 1,
      "body_text": "G3DUWZLyNZXpcX049WpRBaf3KjDC6qB1TsoJunNRw4EW9Ji4VkFiSpeIgNAbScJWP5fhoQCK06S6aTTstuWSdY7otk5rU7ftdePYDF7RpW4PizRMzGPA0woYLtviH8EuNXQ2gkaS4XLBxzogSudXVo",
      "body_image": null,
      "public": "yes",
      "created_at": "2016-11-13 04:14:30",
      "updated_at": "2016-11-13 04:14:30",
      "deleted_at": null
    },
    {
      "id": 4,
      "user_id": 2,
      "body_text": "O2m2iuKSIwxR8fP2x62F5FNsAWee8TpQp4TVp6GaAuxwiI2xxpToPAgHt62YeVzfXXOZcgpn5zcgJOk2bbKyFKLq5WLS17sLgY6Uc90H34D7lDNdDnnLFKDPKhCF1NiviLVRjRp20MD6YqtKf2iQJC",
      "body_image": null,
      "public": "yes",
      "created_at": "2016-11-13 04:14:30",
      "updated_at": "2016-11-13 04:14:30",
      "deleted_at": null
    },
    {
      "id": 3,
      "user_id": 2,
      "body_text": "aBD5ESspjtiYewEzzNhhO6rHNRwEiOLO0O3WagXHArFNZtYezC1Ue954anIwarNKEXt4hxcp4kKrI1FbzkP5PC76cllcaA2hFv4W2s79KkgBQ8BaPVEzQpn18Uq9jz4OTPUkdXxdu7dWC0aYS3ZdtJ",
      "body_image": null,
      "public": "no",
      "created_at": "2016-11-13 04:14:30",
      "updated_at": "2016-11-13 04:14:30",
      "deleted_at": null
    }
  ]
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>GET api/v1/feed</code></p>
        <p><code>HEAD api/v1/feed</code></p>
        <!-- END_23c93a28f85a61981c10370dac908b7c -->
        <!-- START_2be1f0e022faf424f18f30275e61416e -->
        <h2>Basic Login</h2>
        <p>Returns a authentication token to allow the use of the api.</p>
        <p><code>POST https://example.com/api/v1/auth/login</code></p>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>email</td>
                <td>string</td>
                <td>required</td>
            </tr>
            <tr>
                <td>password</td>
                <td>string</td>
                <td>required</td>
            </tr>
            </tbody>
        </table>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl "http://localhost/api/v1/auth/login" \
-H "Accept: application/json"</code></pre>
        <pre><code class="language-javascript">var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/v1/auth/login",
    "method": "POST",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/v1/auth/login</code></p>
        <!-- END_2be1f0e022faf424f18f30275e61416e -->
        <!-- START_58ad7b67903d43ac9b6abf295b5dc3cd -->
        <h2>Social Network Login</h2>
        <p>Returns a authentication token to allow the use of the api.</p>
        <p><code>GET https://example.com/api/v1/{provider}</code></p>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>provider</td>
                <td>string</td>
                <td>required</td>
                <td><code>facebook</code> or <code>google</code></td>
            </tr>
            </tbody>
        </table>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl "http://localhost/api/v1/auth/{provider}" \
-H "Accept: application/json"</code></pre>
        <pre><code class="language-javascript">var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/v1/auth/{provider}",
    "method": "GET",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});</code></pre>
        <blockquote>
            <p>Example response:</p>
        </blockquote>
        <pre><code class="language-json">{
   "user":{  
      "id":3,
      "name":"User Example",
      "email":"Example@example.com",
      "social":"no",
      "created_at":"2016-11-13 04:14:51",
      "updated_at":"2016-11-13 04:55:34",
      "deleted_at":null
   },
   "access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlzcyI6Imh0dHA6XC9cLzE5Mi4xNjguMTAuMTBcL2FwaVwvdjFcL2F1dGhcL2ZhY2Vib29rXC9jYWxsYmFjayIsImlhdCI6MTQ3OTA3NzA5OSwiZXhwIjoxNDc5MDgwNjk5LCJuYmYiOjE0NzkwNzcwOTksImp0aSI6ImEzYTMwMGM1ZmFiYjg0ZjNmMTE2NTE3ZTMyNjFkYWE3In0.Pl6WLlAQQsk_eyxLXvhUjV7V15-fJNR-QcpQXxuHWbA",
   "token_type":"bearer",
   "expires_in":1479080699
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>GET api/v1/auth/{provider}</code></p>
        <p><code>HEAD api/v1/auth/{provider}</code></p>
        <!-- END_58ad7b67903d43ac9b6abf295b5dc3cd -->
        <!-- START_d4601f72a90719299f051e31bd8f894a -->
        <h2>User Feed</h2>
        <p>Get posts and profile data of the specified user. The given posts are based on the authentication state and the
            friendship relation:</p>
        <ul>
            <li>If the user is anonymous, he will only get public posts.</li>
            <li>If he is authenticated and is friend of the specified user beside the public posts he will also get the private ones.</li>
        </ul>
        <p><code>PUT https://example.com/api/v1/users/{id}</code></p>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>id</td>
                <td>int</td>
                <td>required</td>
                <td>the user identifier</td>
            </tr>
            </tbody>
        </table>
        <aside class="notice">
            <b>Optional</b>: You can add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
        </aside>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl "http://localhost/api/v1/users/{id}" \
-H "Accept: application/json"</code></pre>
        <pre><code class="language-javascript">var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/v1/users/{id}",
    "method": "GET",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});</code></pre>
        <blockquote>
            <p>Example response:</p>
        </blockquote>
        <pre><code class="language-json">{
  "id": 2,
  "name": "m3KIm",
  "email": "user2@user2.com",
  "social": "no",
  "created_at": "2016-11-13 04:14:30",
  "updated_at": "2016-11-13 04:14:30",
  "deleted_at": null,
  "posts": {
    "total": 1,
    "per_page": 15,
    "current_page": 1,
    "last_page": 1,
    "next_page_url": null,
    "prev_page_url": null,
    "from": 1,
    "to": 1,
    "data": [
      {
        "id": 4,
        "user_id": 2,
        "body_text": "O2m2iuKSIwxR8fP2x62F5FNsAWee8TpQp4TVp6GaAuxwiI2xxpToPAgHt62YeVzfXXOZcgpn5zcgJOk2bbKyFKLq5WLS17sLgY6Uc90H34D7lDNdDnnLFKDPKhCF1NiviLVRjRp20MD6YqtKf2iQJC",
        "body_image": null,
        "public": "yes",
        "created_at": "2016-11-13 04:14:30",
        "updated_at": "2016-11-13 04:14:30",
        "deleted_at": null
      }
    ]
  }
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>GET api/v1/users/{id}</code></p>
        <p><code>HEAD api/v1/users/{id}</code></p>
        <!-- END_d4601f72a90719299f051e31bd8f894a -->
        <!-- START_4194ceb9a20b7f80b61d14d44df366b4 -->
        <h2>Create Account</h2>
        <p>Create a new account for the given data</p>
        <p><code>POST https://example.com/api/v1/users</code></p>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>name</td>
                <td>string</td>
                <td>required</td>
                <td>max length: 100</td>
            </tr>
            <tr>
                <td>email</td>
                <td>string</td>
                <td>required</td>
                <td>Has to be email format</td>
            </tr>
            <tr>
                <td>password</td>
                <td>string</td>
                <td>required</td>
                <td></td>
            </tr>
            </tbody>
        </table>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl "http://localhost/api/v1/users" \
-H "Accept: application/json"</code></pre>
        <pre><code class="language-javascript">var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/v1/users",
    "method": "POST",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/v1/users</code></p>
        <!-- END_4194ceb9a20b7f80b61d14d44df366b4 -->
        <!-- START_8c8dee3dc083fa8a3bbfd25342a7c1b6 -->
        <h2>Create Post</h2>
        <p>Create a post from the authenticated user
            Returns the public user information</p>
        <p><code>POST https://example.com/api/v1/posts</code></p>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>body_text</td>
                <td>string</td>
                <td>optional</td>
                <td>post text message</td>
            </tr>
            <tr>
                <td>body_image</td>
                <td>image</td>
                <td>optional</td>
                <td>post image file</td>
            </tr>
            <tr>
                <td>public</td>
                <td>string</td>
                <td>required</td>
                <td>post visibility: <code>yes</code> or <code>no</code></td>
            </tr>
            </tbody>
        </table>
        <p>Note: at least one body part need to be submitted</p>
        <aside class="warning">
            <b>Required</b>: You must add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
        </aside>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl "http://localhost/api/v1/posts" \
-H "Accept: application/json"</code></pre>
        <pre><code class="language-javascript">var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/v1/posts",
    "method": "POST",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/v1/posts</code></p>
        <!-- END_8c8dee3dc083fa8a3bbfd25342a7c1b6 -->
        <!-- START_87be16b21ad5a10b0cebd40a3cfdddbc -->
        <h2>Update/Edit Post</h2>
        <p>Edit the data of a post. Return the post with the updated data.</p>
        <p><code>PUT https://example.com/api/v1/posts/{post}</code></p>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>post</td>
                <td>int</td>
                <td>required</td>
                <td>the post identifier</td>
            </tr>
            </tbody>
        </table>
        <aside class="warning">
            <b>Required</b>: You must add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
        </aside>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl "http://localhost/api/v1/posts/{post}" \
-H "Accept: application/json"</code></pre>
        <pre><code class="language-javascript">var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/v1/posts/{post}",
    "method": "PUT",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});</code></pre>
        <h3>HTTP Request</h3>
        <p><code>PUT api/v1/posts/{post}</code></p>
        <!-- END_87be16b21ad5a10b0cebd40a3cfdddbc -->
        <!-- START_b59514618939469a1367e18797eec2b3 -->
        <h2>Remove Post</h2>
        <p>Remove a post.</p>
        <p><code>DELETE https://example.com/api/v1/posts/{post}</code></p>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>post</td>
                <td>int</td>
                <td>required</td>
                <td>the post identifier</td>
            </tr>
            </tbody>
        </table>
        <aside class="warning">
            <b>Required</b>: You must add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
        </aside>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl "http://localhost/api/v1/posts/{post}" \
-H "Accept: application/json"</code></pre>
        <pre><code class="language-javascript">var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/v1/posts/{post}",
    "method": "DELETE",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});</code></pre>
        <h3>HTTP Request</h3>
        <p><code>DELETE api/v1/posts/{post}</code></p>
        <!-- END_b59514618939469a1367e18797eec2b3 -->
        <!-- START_a7b6b2c36a97e08b742b0af6a4777662 -->
        <h2>Get Image</h2>
        <p>Get image resource</p>
        <p><code>GET https://example.com/api/v1/images/{filename}</code></p>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>filename</td>
                <td>string</td>
                <td>required</td>
                <td>image filename</td>
            </tr>
            </tbody>
        </table>
        <aside class="warning">
            <b>Required</b>: You must add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
        </aside>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl "http://localhost/api/v1/images/{filename}" \
-H "Accept: application/json"</code></pre>
        <pre><code class="language-javascript">var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/v1/images/{filename}",
    "method": "GET",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});</code></pre>
        <h3>HTTP Request</h3>
        <p><code>GET api/v1/images/{filename}</code></p>
        <p><code>HEAD api/v1/images/{filename}</code></p>
        <!-- END_a7b6b2c36a97e08b742b0af6a4777662 -->
        <!-- START_87acc92804c271be403e4d34a54d3b45 -->
        <h2>Add Friend</h2>
        <p>Set friendship between the authenticated user and the given friend identifier.</p>
        <p><code>POST https://example.com/api/v1/friends</code></p>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>friend</td>
                <td>int</td>
                <td>required</td>
                <td>the friend identifier</td>
            </tr>
            </tbody>
        </table>
        <aside class="warning">
            <b>Required</b>: You must add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
        </aside>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl "http://localhost/api/v1/friends" \
-H "Accept: application/json"</code></pre>
        <pre><code class="language-javascript">var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/v1/friends",
    "method": "POST",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/v1/friends</code></p>
        <!-- END_87acc92804c271be403e4d34a54d3b45 -->
        <!-- START_b5804896db12e24b91aaef4d5ae0e1cb -->
        <h2>Friends List</h2>
        <p>Return the friends of the authenticated user.</p>
        <p><code>GET https://example.com/api/v1/friends</code></p>
        <aside class="warning">
            <b>Required</b>: You must add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
        </aside>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl "http://localhost/api/v1/friends" \
-H "Accept: application/json"</code></pre>
        <pre><code class="language-javascript">var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/v1/friends",
    "method": "GET",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});</code></pre>
        <blockquote>
            <p>Example response:</p>
        </blockquote>
        <pre><code class="language-json">{
  "total": 1,
  "per_page": 15,
  "current_page": 1,
  "last_page": 1,
  "next_page_url": null,
  "prev_page_url": null,
  "from": 1,
  "to": 1,
  "data": [
    {
      "id": 2,
      "name": "m3KIm",
      "email": "user2@user2.com",
      "social": "no",
      "created_at": "2016-11-13 04:14:30",
      "updated_at": "2016-11-13 04:14:30",
      "deleted_at": null,
      "pivot": {
        "user_id_1": 3,
        "user_id_2": 2
      }
    }
  ]
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>GET api/v1/friends</code></p>
        <p><code>HEAD api/v1/friends</code></p>
        <!-- END_b5804896db12e24b91aaef4d5ae0e1cb -->
    </div>
    <div class="dark-box">
        <div class="lang-selector">
            <a href="#" data-language-name="bash">bash</a>
            <a href="#" data-language-name="javascript">javascript</a>
        </div>
    </div>
</div>
</body>
</html>
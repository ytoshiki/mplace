<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel='icon' href='<?php echo URLROOT ?>/app/views/images/favicon.png' type='image/x-icon'/ >
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/app/views/styles/main.css">
  <title>Flipboard</title>
</head>
<body>

<div class="bookmark_modal">
  <div class="modal_wrapper">
    <div class="bookmark_shadow"></div>
    <div class="modal_content">
      <h3>WANT MORE STORIES?</h3>
      <p>Sign up for more favourite stories</p>
      <a href="<?php echo URLROOT ?>/user/signup" id="signup_button">
          Sign up
      </a>
    </div>
  </div>
</div>

<div class="url_modal">
  <div class="modal_wrapper">
    <div class="url_shadow"></div>
    <div class="modal_content">
      <h3>COPY THE URL ADDRESS</h3>
      <p>SHARE THE LINK WITH YOUR FRIENDS</p>
      <span class="url_insert"></span><span class="copy_button">COPY</span>
    </div>
  </div>
</div>



<h1> Huffman Encoding </h1>
<?php  echo view("forms/huffman_encodingForm") ; 

?>

<div id="authorised"> </div>
 <div class="card" role="region" aria-label="Rotating bunny">
    <!-- Simple friendly bunny SVG (no external files) -->
    <svg class="bunny" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <!-- ears -->
      <g fill="#fff" stroke="#222" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
        <path d="M50 30c-8 18-6 52 10 64 8 6 24-6 26-14 4-18-16-58-36-50z" fill="#fff"/>
        <path d="M150 30c8 18 6 52-10 64-8 6-24-6-26-14-4-18 16-58 36-50z" fill="#fff"/>
      </g>
      <!-- head -->
      <g transform="translate(0,12)">
        <ellipse cx="100" cy="110" rx="68" ry="56" fill="#fff" stroke="#222" stroke-width="3"/>
        <!-- eyes -->
        <circle cx="80" cy="100" r="6" fill="#222"/>
        <circle cx="120" cy="100" r="6" fill="#222"/>
        <!-- nose -->
        <path d="M98 118 q2 6 6 6 q4 0 6-6 q-7 4-12 0z" fill="#f39"/>
        <!-- whiskers -->
        <g stroke="#222" stroke-linecap="round" stroke-width="2">
          <path d="M60 116 h-24" />
          <path d="M60 122 h-20" />
          <path d="M140 116 h24" />
          <path d="M140 122 h20" />
        </g>
      </g>
    </svg>

    <div class="caption">Spinning bunny — powered by PHP + CSS</div>
    <div class="small">Change the <code>--duration</code> CSS variable to speed up or slow down the spin.</div>
  </div>
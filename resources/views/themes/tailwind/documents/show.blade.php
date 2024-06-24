<!DOCTYPE html> 
<html> 
  <head> 
    <meta charset="UTF-8" /> 
    <link href= "https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet"/> 
  </head> 
  <body style="height: 1000px"> 
    <h1 style="color: green;  
               text-align: center"> 
        GeeksforGeeks 
    </h1> 
    
    <header class="text-2xl text-center  
                   text-green-800 border-b-2  
                   border-grey-500"> 
      Sticky footer using Tailwind CSS 
    </header> 

    <div> 
      <p class="p-2 w-9/12"> 
      <header>

            <!-- Section: Split screen -->
            <section class="">

            <!-- Grid -->
            <div class="grid grid-cols-2 h-screen">

                <!-- First column -->
                <div class="">
            dfgdfgdfg
                </div>
                <!-- First column -->

                <!-- Second column -->
                <div class="">
            wwwwwwwwwwwwww
                
                </div>
                <!-- Second column -->

            </div>
            <!-- Grid -->

            </section>
            <!-- Section: Split screen -->

        </header>
      </p> 
    </div> 

    <footer
      class="bg-green-700 
             text-3xl text-white text-center 
             border-t-4 border-red-500 
             fixed 
             inset-x-0 
             bottom-0 
             p-4"> 
      This is sticky fixed Footer. 
    </footer> 
  </body> 
</html> 
 //Setup event handlers
        window.addEventListener("load", setupEventHandlers, false);

        //-------------------------------
        // name: setupEventHandlers()
        //-------------------------------
        function setupEventHandlers()
        {

            console.log("Inside setupEventHandlers function that is fired on the window load event");

            //Event handlers
            var HelloWorldButtonReference = document.getElementById("butHelloWorld");
            HelloWorldButtonReference.addEventListener("click", displayHelloWorld, false);


            


            var HelloWorldAgainButtonReference = document.getElementById("butHelloWorldAgain");
            HelloWorldAgainButtonReference.addEventListener("click", displayHelloWorldAgain, false);
        }
        
        
        //------------------------------------------------------
        // name: displayHelloWorld()
        // description: Function called when button is clicked
        //------------------------------------------------------
           function displayHelloWorld()
        {
            console.log("Inside displayHelloWorld function");

            document.getElementById('divHelloWorld').innerHTML = "<h1>Hello World!</h1>";
        }

       
           
        
        function displayHelloWorldAgain()
        {
            console.log("Inside displayHelloWorldAgain function");

            document.getElementById('divDisplay2').innerHTML = "<h2>Hello World Again!</h2>";
        }

# voice-assistant
This project is a voice assistant chatbot that converts speech into text and sends it to the Gemini API through a PHP backend, then displays and reads the AI response.

In this project, I worked on a voice assistant chatbot that uses the Gemini API. The chatbot allows the user to speak using the microphone and it converts the speech into text. Then, the text is sent to the PHP backend, and the backend sends the request to the Gemini API. Finally, the chatbot receives the response, displays it on the screen, and reads it aloud using text-to-speech.

First, I created  my personal folder for the project inside the **htdocs** directory in XAMPP, I copied all the project files Then I started the Apache server from the XAMPP Control Panel and opened the project in my browser using localhost.

After running the project, I tested all the features to make sure they were working correctly. I checked the user interface, the microphone button, the speech recognition feature and the connection between the frontend and the backend. I also made sure that the JavaScript file sends the user's speech to the PHP backend instead of connecting directly to the Gemini API. This keeps the API key secure because it is stored only on the server inside the config.php file.

## Problems Found and Fixes
While testing the project, I found that the PHP backend was using an outdated method to connect to the Gemini API. The original code was sending the API key as a URL parameter, which did not work with the new API key. I updated the backend code to use the new **X-goog-api-key** authentication method, and after that the connection to the Gemini API worked correctly.

I also tested the project on InfinityFree to make sure it could be deployed online. During testing, I found that InfinityFree returned a 403 Forbidden error because the backend file was named **chat.php**. I renamed the file to **gemini.php**, and I updated the backend path inside the JavaScript file so that the frontend could communicate with the correct PHP file.

After making these changes, I tested the project again, and I confirmed that the application was working correctly on my local XAMPP server. The chatbot was able to recognize speech, send the request to the backend, receive the response from Gemini, and display the answer successfully.

## Security Note
I removed my personal Gemini API key from the config.php file before submitting the project.

For security reasons, I removed my personal Gemini API key from the `config.php` file before submitting the project. Anyone who wants to run the project only needs to generate their own Gemini API key and add it to the configuration file.

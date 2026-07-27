# voice-assistant
This project is a voice assistant chatbot that converts speech into text and sends it to the Gemini API through a PHP backend, then displays and reads the AI response.

In this project, I worked on a voice assistant chatbot that uses the Gemini API. The chatbot allows the user to speak using the microphone and it converts the speech into text. Then, the text is sent to the PHP backend, and the backend sends the request to the Gemini API. Finally, the chatbot receives the response, displays it on the screen, and reads it aloud using text-to-speech.

First, I created my personal folder for the project inside the **htdocs** directory in XAMPP, Then, I copied all the project files, including the HTML, CSS, JavaScript, PHP, and configuration files into the project folder.
After that, I organized the project structure by moving the backend PHP file into a new **api** folder. I also updated the backend path inside **app.js** so the frontend could communicate with the correct PHP file.

Then, I started the Apache server from XAMPP and tested the project using **localhost**. I checked that the microphone, speech recognition, backend connection, and chatbot responses were working correctly.


## Problems Found and Fixes

While testing the project, I found that the PHP backend was using an outdated method to authenticate with the Gemini API. The original code was sending the API key using an old method, so I updated the backend to use the new **X-goog-api-key** authentication method. After making this change, the backend connected successfully to the Gemini API.

I also tested the project on InfinityFree. During deployment, I received a **403 Forbidden** error because the hosting service blocked the backend file named **chat.php**. To continue testing, I renamed the file to **gemini.php** and updated the backend path inside **app.js**.

I also verified that the Gemini API key was stored securely inside **config.php** instead of exposing it in the JavaScript code, which improves the security of the application.

## Security Note
For security reasons, I removed my personal Gemini API key from the `config.php` file before submitting this project.





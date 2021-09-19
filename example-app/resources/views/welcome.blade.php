<!DOCTYPE html>
<html>
    <head>
        <title>Elephant.IO Nofication</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <style>
            body { margin: 0; padding-bottom: 3rem; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; }

            #form { background: rgba(0, 0, 0, 0.15); padding: 0.25rem; position: fixed; bottom: 0; left: 0; right: 0; display: flex; height: 3rem; box-sizing: border-box; backdrop-filter: blur(10px); }
            #input { border: none; padding: 0 1rem; flex-grow: 1; border-radius: 2rem; margin: 0.25rem; }
            #input:focus { outline: none; }
            #form > button { background: #333; border: none; padding: 0 1rem; margin: 0.25rem; border-radius: 3px; outline: none; color: #fff; }

            #messages { list-style-type: none; margin: 0; padding: 0; }
            #messages > li { padding: 0.5rem 1rem; }
            #messages > li:nth-child(odd) { background: #efefef; }
        </style>
    </head>
    <body>
        <ul id="messages"></ul>
        <form id="form" action="">
        <input id="input" autocomplete="off" /><button>Send</button>
        </form>

        <script>
            var messages = document.getElementById('messages');
            var form = document.getElementById('form');
            var input = document.getElementById('input');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (input.value) {
                    var item = document.createElement('li');
                    item.textContent = input.value;
                    messages.appendChild(item);
                    window.scrollTo(0, document.body.scrollHeight);

                    postData('/notification', { msg: input.value })
                    .then(data => {
                        console.log(data); // JSON data parsed by `data.json()` call
                        input.value = '';
                    });
                }
            });

            // Example POST method implementation:
            async function postData(url = '', data = {}) {
                // Default options are marked with *
                const response = await fetch(url, {
                    method: 'POST', // *GET, POST, PUT, DELETE, etc.
                    mode: 'cors', // no-cors, *cors, same-origin
                    cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                    credentials: 'same-origin', // include, *same-origin, omit
                    headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                    // 'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    redirect: 'follow', // manual, *follow, error
                    referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                    body: JSON.stringify(data) // body data type must match "Content-Type" header
                });
                return response.json(); // parses JSON response into native JavaScript objects
            }
        </script>
    </body>
</html>

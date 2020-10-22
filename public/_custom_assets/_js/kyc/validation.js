const API_URL = "http://crm.test/api/";
function renderVerifyButton(){
    const element = document.getElementById("passbase-button");
    const apiKey = "OBQjHmUWwd1NR4mCIBufUP4i3oHzdRIOMqimkROM5vWETmIqGZyeCsfvRSl4OI9v"; // current key: sandbox
    const userId = "123456";
    const onFinished = (error, authKey, additionalAttributes) => {
        if (error) {
            console.log("Error: " + error);
        } else {
            const body = {
                authKey: authKey,
                userId: userId,
            };
            const requestOptions = {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(body),
            };
            console.log(requestOptions);
            // fetch(
            //     API_URL + "new_auth",
            //     requestOptions
            // );
        }
    };

    Passbase.renderButton(element, onFinished, apiKey, {
        integrationType: "signup",
        additionalAttributes: {
            userId: userId,
        },
        prefillAttributes: {
            country: "en",
        },
        theme: {
            accentColor: "",
            font: "Arial",
        },
    });
}
renderVerifyButton();
// Passbase.renderButton(
//     document.getElementById("passbase-button"),
//     (err, passport) => {},
//     "64nMySMAwS7ElPOJfSMWoSUv3AmJynLS3QefSojoRlZoP3pFjXPGrQBwdYnhCiFa",
//     {
//         additionalAttributes: {
//             // Add your internal references here
//             // customer_user_id": "YOUR_INTERNAL_USER_ID",
//         }
//     }
// );

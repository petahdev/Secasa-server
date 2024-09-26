<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Email Privilege</title>
    <style>
        body {
            background-color: #202221; /* Background color from the first document */
            color: #ffffff; /* Text color from the first document */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #2c2f34; /* Container background from the first document */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            color: #22c55e; /* Heading color from the first document */
            text-align: center;
        }
        p {
            line-height: 1.6;
            font-size: 1.1em;
            margin: 20px 0;
            text-align: justify;
        }
        label {
            display: block;
            margin-top: 20px;
            font-size: 1.1em;
            color: #ffffff; /* Label text color to match body */
        }
        input[type="checkbox"] {
            margin-right: 10px;
            accent-color: #22c55e; /* Checkbox accent color from the first document */
        }
        .button-group {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }
        button {
            padding: 10px 20px;
            font-size: 1.1em;
            background-color: #22c55e; /* Button color from the first document */
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #1ea34b; /* Hover color from the first document */
        }
        button:disabled {
            background-color: grey; /* Disabled button color */
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Admin Email Privilege</h1>
    <p>
        Sending emails as an admin within the SECASA system is a privilege granted only to authorized personnel. 
        As an admin, you are entrusted with the ability to communicate vital information to members of your group 
        or to the entire SECASA community. This responsibility should be handled with care, ensuring that only 
        important and relevant information is disseminated.
    </p>
    <p>
        The ability to send group-wide or campus-wide emails is reserved for verified admins. There are two types 
        of admins in the SECASA system: 
    </p>
    <ul>
        <li><strong>SECASA Admin:</strong> These admins can send emails to all members across various groups within SECASA. This includes important announcements or upcoming event reminders.</li>
        <li><strong>Group Admin:</strong> These admins can send emails to the members of their specific group only. Group admins handle more focused, group-specific communications.</li>
    </ul>
    <p>
        Misuse of this privilege may result in your removal from the admin role. Please ensure that you have the 
        appropriate authorization before proceeding to send any emails. All messages sent will be logged, and 
        inappropriate use will be flagged.
    </p>
    <p>
        To proceed as an admin, you must confirm that you have been granted the appropriate privileges by SECASA 
        leadership. Please check the box below to confirm.
    </p>
    
    <form id="admin-form" onsubmit="return validateForm()">
        <label>
            <input type="checkbox" id="admin-confirmation" required> I confirm that I am an authorized SECASA admin or Group admin.
        </label>
        <div class="button-group">
            <button type="button" id="secasa-admin-btn" onclick="proceedAsAdmin('SECASA')" disabled>Proceed as SECASA Admin</button>
            <button type="button" id="group-admin-btn" onclick="proceedAsAdmin('Group')" disabled>Proceed as Group Admin</button>
        </div>
    </form>
</div>

<script>
    // Enable the buttons when the checkbox is checked
    const adminConfirmationCheckbox = document.getElementById('admin-confirmation');
    const secasaAdminButton = document.getElementById('secasa-admin-btn');
    const groupAdminButton = document.getElementById('group-admin-btn');

    adminConfirmationCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;
        secasaAdminButton.disabled = !isChecked;
        groupAdminButton.disabled = !isChecked;
    });

    function validateForm() {
        const checkbox = document.getElementById('admin-confirmation');
        if (!checkbox.checked) {
            alert('You must confirm your admin privileges before proceeding.');
            return false;
        }
        return true;
    }

    function proceedAsAdmin(adminType) {
        alert(`Proceeding as ${adminType} Admin.`);
        if (adminType === 'SECASA') {
            window.location.href = 'admin-login.php'; // Redirect to SECASA Admin login
        } else {
            window.location.href = 'groups_admin.php'; // Redirect to Group Admin login
        }
    }
</script>

</body>
</html>

<html>
<head>
</head>
<body>
<form id="form-contact_v1" name="form-contact_v1">

    <div class="control-group">
        <label class="control-label" for="contact_v1-name">Full name</label>
        <div class="controls">

            <input type="text" id="contact_v1-name" name="contact_v1[name]" data-validation="[NOTEMPTY, NAME, L>10]">

        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="contact_v1-email">Email address</label>
        <div class="controls">

            <input type="text" id="contact_v1-email" name="contact_v1[email]" data-validation="[EMAIL]">

        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Topic</label>
        <div class="controls select">

            <select name="contact_v1[topic]" data-validation="[NOTEMPTY]">
                <option value="">Choose a topic</option>
                <option value="1">General Support / Feedback</option>
                <option value="2">Copyright / Trademark Violations</option>
                <option value="3">Business Inquiries</option>
                <option value="4">Advertising</option>
                <option value="10">Other</option>
            </select>

        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="contact_v1-subject">Subject</label>
        <div class="controls">

            <input type="text" id="contact_v1-subject" name="contact_v1[subject]" class="input-xxxlarge" data-validation="[L>=2]" data-validation-label="This custom label from attribute">

        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="contact_v1-message">Message <small>Maximum 1000 characters</small></label>
        <div class="controls">

            <textarea id="contact_v1-message" name="contact_v1[message]" data-validation="[NOTEMPTY, L>=20, L<=1000]" rows="3">   </textarea>

        </div>
    </div>

    <input type="submit" class="ui blue submit button" value="Send">

</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/additional-methods.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>

<script>
    // Custom labels for error display
    Validation.labels = {
        'contact_v1[email]': 'Custom label name from configuration'
    };

    // This instance has priority over global messages
    $('#form-contact_v1').validate({
        submit: {
            settings: {
                inputContainer: ".control-group",
                allErrors: true,
                errorListClass: "attention icon"
            }
        },
        messages: {
            'NOTEMPTY': 'Overriding the NOTEMPTY message for this instance'
        },
        labels: {
            'contact_v1[message]': 'Custom label name from initialization'
        }
    });
</script>

</body>
</html>
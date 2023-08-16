<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz-Maker</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="editQuestion.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript" src="Scirpts/search.js" defer="defer"></script>
    <script type="text/javascript" src="Scirpts/update.js" defer="defer"></script>
</head>

<body>
    <div id="dialog" title="Updating message"></div>
    <form method="post"> <!-- Use POST for updates -->
        <fieldset>
            <legend>Search and Edit Question</legend>
            <label for="searchByQID">Search Question By ID</label>
            <input type="radio" id="searchByQID" name="searchById"><br>
            <label for="searchByQSyntax">Search Question By Question Syntax</label>
            <input type="radio" id="searchByQSyntax" name="searchBySyntax"><br>
            <div style="display:none;" id="searchQuestionToEdit-div">
                <label id="searchLabel" for="searchBar">Search Question:</label>
                <input type="text" id="searchBar">
                <button id="startSearch">Search</button>
            </div>
            <div style="display:none;" id="EditQuestion-div">
                <!-- Edit question content here -->
            </div>
        </fieldset>
    </form>
</body>

</html>
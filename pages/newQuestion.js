export default () => {
    const container = document.createElement('div');
    const template = `
    
    <div class="head-title">
    <div class="left">
        <h1>Nova Questão</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Painel</a>
            </li>
            <li><i class='bx bx-chevron-right' ></i></li>
            <li>
                <a class="active" href="#">Home</a>
            </li>
        </ul>
    </div>
</div>


<div class="table-data">
    <div class="order">
        <form>
            <label for="question">Question:</label>
            <input type="text" id="question" name="question"><br><br>

            <label for="img1">Image 1:</label>
            <input type="text" id="img1" name="img1"><br><br>

            <label for="year">Year:</label>
            <input type="text" id="year" name="year"><br><br>

            <label for="related_contents">Related Contents:</label>
            <input type="text" id="related_contents" name="related_contents"><br><br>

            <label for="keys">Keys:</label>
            <input type="text" id="keys" name="keys"><br><br>

            <label for="discipline">Discipline:</label>
            <input type="text" id="discipline" name="discipline"><br><br>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject"><br><br>

            <label for="banca">Banca:</label>
            <input type="text" id="banca" name="banca"><br><br>

            <label for="agency">Agency:</label>
            <input type="text" id="agency" name="agency"><br><br>

            <label for="job_position">Job Position:</label>
            <input type="text" id="job_position" name="job_position"><br><br>

            <label for="grade_level">Grade Level:</label>
            <input type="text" id="grade_level" name="grade_level"><br><br>

            <label for="course">Course:</label>
            <input type="text" id="course" name="course"><br><br>

            <label for="question_type">Question Type:</label>
            <input type="text" id="question_type" name="question_type"><br><br>

            <label for="level">Level:</label>
            <input type="text" id="level" name="level"><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</div>

`;
               
    container.innerHTML = template;
    return container;
}

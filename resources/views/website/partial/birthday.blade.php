
<style>
.scroll-content{
font-size: 15px;
}

#birthdays{
    margin-left: 60px;
}
#anniversaries{
    margin-left: 60px;
}
h3{
    margin-left:65px;
}
</style>

<div class="scroll-container">
    <div class="scroll-content">
        <h3>Birthdays</h3>
        <div id="birthdays"></div> <!-- Placeholder for birthdays -->

        <h3>Anniversaries</h3>
        <div id="anniversaries"></div> <!-- Placeholder for anniversaries -->
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchCelebrations();
    });

    function fetchCelebrations() {
        fetch('/get-celebrations') // Ensure this matches your Laravel route
            .then(response => {
                if (!response.ok) {
                    throw new Error("Failed to fetch celebrations.");
                }
                return response.json();
            })
            .then(data => {
                let birthdaysHTML = "";
                let anniversariesHTML = "";

                let today = new Date().toLocaleDateString("en-US", {
                    month: "long",
                    day: "numeric"
                });

                if (Array.isArray(data.birthdays) && data.birthdays.length > 0) {
                    data.birthdays.forEach(birthday => {
                        birthdaysHTML += `<p>🎂 Happy Birthday, ${birthday.first_name} ${birthday.last_name}! 🎉 (${today})</p>`;
                    });
                } else {
                    birthdaysHTML = `<p>No birthdays today.</p>`;
                }

                if (Array.isArray(data.anniversaries) && data.anniversaries.length > 0) {
                    data.anniversaries.forEach(anniversary => {
                        anniversariesHTML += `<p>💍 Happy Anniversary, ${anniversary.first_name} ${anniversary.last_name}! ❤️ (${today})</p>`;
                    });
                } else {
                    anniversariesHTML = `<p>No anniversaries today.</p>`;
                }

                document.getElementById("birthdays").innerHTML = birthdaysHTML;
                document.getElementById("anniversaries").innerHTML = anniversariesHTML;
            })
            .catch(error => {
                console.error("Error fetching celebrations:", error);
                document.getElementById("birthdays").innerHTML = `<p>Error loading birthdays.</p>`;
                document.getElementById("anniversaries").innerHTML = `<p>Error loading anniversaries.</p>`;
            });
    }
</script>

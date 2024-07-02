document.addEventListener("DOMContentLoaded", function() {
    const commentButtons = document.querySelectorAll(".comment-btn");
    const viewCommentButtons = document.querySelectorAll(".view-comments-btn");

    commentButtons.forEach(button => {
        button.addEventListener("click", function() {
            const articleId = this.getAttribute("data-article-id");
            const formContainer = document.getElementById("comment-form-" + articleId);
            if (formContainer.style.display === "block") {
                formContainer.style.display = "none";
            } else {
                formContainer.style.display = "block";
            }
        });
    });

    viewCommentButtons.forEach(button => {
        button.addEventListener("click", function() {
            const articleId = this.getAttribute("data-article-id");
            const commentsContainer = document.getElementById("comments-" + articleId);
            if (commentsContainer.style.display === "block") {
                commentsContainer.style.display = "none";
            } else {
                commentsContainer.style.display = "block";
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const postsContainer = document.getElementById("posts-container");
    const addedPostIDs = [];

    fetch("ajax/fetch_posts.php")
        .then(response => response.json())
        .then(data => {
            data.forEach(post => {
                if (!addedPostIDs.includes(post.PostID)) {
                    addedPostIDs.push(post.PostID); 
                    fetchImageURL(post.ImageID)
                        .then(imageURL => {
                            post.ImageURL = imageURL; 

                            
                            fetchCommentCount(post.PostID)
                                .then(commentCount => {
                                    post.CommentID = commentCount; 
                                    const postElement = createPostElement(post);
                                    postsContainer.appendChild(postElement);
                                })
                                .catch(error => {
                                    console.error("Error fetching comment count:", error);
                                });
                        })
                        .catch(error => {
                            console.error("Error fetching image URL:", error);
                        });
                }
            });
        })
        .catch(error => {
            console.error("Error fetching data:", error);
        });

        async function fetchImageURL(imageID) {
            const response = await fetch(`ajax/fetch_image_url.php?imageID=${imageID}`);
            const data = await response.json();
            return data.ImageURL;
        }

        async function fetchUserName(userID) {
            const response = await fetch(`ajax/get_user_name.php?userID=${userID}`);
            const data = await response.json();
            return data.userName;
        }

        async function fetchCommentCount(postID) {
            const response = await fetch(`ajax/get_comment_count.php?post_id=${postID}`);
            const data = await response.json();
            return data.commentCount;
        }

        function createPostElement(post) {
            const postDiv = document.createElement("div");
            postDiv.className = "post";
        
            const postLink = document.createElement("a"); // Create an anchor element
            postLink.href = `post.php?post_id=${post.PostID}`;
            postLink.style.textDecoration = "none";
            postLink.style.color = "black";
        
            const postTitle = document.createElement("h2");
            postTitle.textContent = post.Title;
        
            const postContent = document.createElement("p");
            postContent.className = "post-content";
            postContent.textContent = post.Text;
        
            const postImage = document.createElement("img");
            postImage.src = post.ImageURL;
        
            const postInfo = document.createElement("div");
            postInfo.className = "post-info";
        
            // Fetch user name
            fetch(`ajax/get_user_name.php?userID=${post.UserID}`)
                .then(response => response.json())
                .then(data => {
                    const userName = data.userName;
                    postInfo.innerHTML = `
                        <span class="post-date">Posted by ${userName} on ${post.PostDate}</span>
                        <span class="comment-link">Comments (${post.CommentID})</span>
                    `;
                })
                .catch(error => {
                    console.error("Error fetching user data:", error);
                });
        
            postLink.appendChild(postTitle);
            postDiv.appendChild(postLink);
            postDiv.appendChild(postContent);
            postDiv.appendChild(postImage);
            postDiv.appendChild(postInfo);
        
            return postDiv;
        }        
});

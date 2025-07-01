<?php
// Start session and include DB config
session_start();
include("config/config.php");

// Fetch all blogs from the database without ordering
$sql_blogs = "SELECT * FROM blog";
$result = mysqli_query($conn, $sql_blogs);
$rowcount = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/newstyle.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Blogs</title>

  <style>



    .blogs-section {
        display: flex;
        flex-direction: column;
        gap: 20px;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .blog-card {
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        overflow: hidden;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        width: 100%;
        max-width: 800px;
    }

    .blog-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    }

    .blog-img-section {
        flex: 0 0 200px;
        height: 150px;
        overflow: hidden;
    }

    .blog-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .blog-content {
        flex: 1;
        padding: 20px;
        text-align: left;
    }

    .blog-content h3 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #222;
        margin: 0;
    }

    .blog-content h3:hover {
        color: #007bff; 
        transition: color 0.3s ease-in-out;
    }

    .blog-content p {
        font-size: 1.1rem;
        font-weight: 400;
        color: #555;
        margin-top: 12px;
        line-height: 1.6;
    }

    h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #222;
        text-align: center;
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .blog-card {
            flex-direction: column;
            text-align: center;
        }

        .blog-img-section {
            flex: none;
            height: 200px;
        }

        .blog-content {
            text-align: center;
        }

        .blog-content h3 {
            font-size: 1.6rem;
        }

        .blog-content p {
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        h2 {
            font-size: 2rem;
        }

        .blog-content h3 {
            font-size: 1.4rem;
        }

        .blog-content p {
            font-size: 0.9rem;
        }
    }
  </style>

</head>
<body>

    <main>
    <?php
		include("includes/userNav.php");
	?>
      <h2>Blog</h2>
      <div class="blogs-section">
        <?php if ($rowcount > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="blog-card">
              <div class="blog-img-section">
                <img src="<?php echo BASE_URL . '/' . htmlspecialchars($row['image']); ?>" alt="Blog Image" class="blog-img">
              </div>
              <div class="blog-content">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p><strong>No blogs available at the moment.</strong></p>
        <?php endif; ?>
      </div>
    </main>

</body>
</html>

<?php
mysqli_free_result($result);
mysqli_close($conn);
?>
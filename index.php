<?php
// Database connection parameters
$host = "localhost";
$user = "root";
$password = "";
$database = "berita";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to update the view count
function updateViewCount($conn, $postId) {
    $sql = "UPDATE posts SET view = view + 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }
    $stmt->bind_param("i", $postId);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        echo "Failed to update view count: " . $stmt->error;
        $stmt->close();
        return false;
    }
}

// Function to fetch recent posts with pagination and category filter
function fetchRecentPosts($conn, $limit, $offset, $kategori = '') {
    $sql = "SELECT id, judul, isi, images, view FROM posts";
    if ($kategori) {
        $sql .= " WHERE kategori = ?";
    }
    $sql .= " ORDER BY tanggal_publikasi DESC LIMIT ? OFFSET ?";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }

    if ($kategori) {
        $stmt->bind_param("sii", $kategori, $limit, $offset);
    } else {
        $stmt->bind_param("ii", $limit, $offset);
    }

    $stmt->execute();
    return $stmt->get_result();
}

// Function to fetch trending posts
function fetchTrendingPosts($conn) {
    $sql = "SELECT id, judul, isi, images, view FROM posts ORDER BY view DESC LIMIT 5";
    return $conn->query($sql);
}

// Pagination setup
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Cek kategori dari URL
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$recentPosts = fetchRecentPosts($conn, $limit, $offset, $kategori);
$trendingPosts = fetchTrendingPosts($conn);

$totalPostsResult = $conn->query("SELECT COUNT(*) as count FROM posts" . ($kategori ? " WHERE kategori = '$kategori'" : ""));
$totalPosts = $totalPostsResult->fetch_assoc()['count'];
$totalPages = ceil($totalPosts / $limit);

if (isset($_GET['id'])) {
    $postId = (int)$_GET['id'];
    if (updateViewCount($conn, $postId)) {
        echo "View count updated successfully.";
    } else {
        echo "Failed to update view count.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Web Programming - Final Semester Exam</title>
    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <style>
        /* Styles tetap sama */
        .sidebar {
            float: right;
            width: 30%;
        }
        .main-content {
            float: left;
            width: 65%;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 12px;
            border: 1px solid #007bff;
            color: #007bff;
            text-decoration: none;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
        }
        .post {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        .post h3 {
            margin: 0 10px 0 0;
        }
        .post img {
            max-width: 150px;
            height: auto;
            margin-left: 15px;
        }
        .trending-post {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .trending-post h5 {
            margin: 0 0 5px;
        }
        .trending-post p {
            margin: 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
<header class="w3l-header">
    <nav class="navbar navbar-expand-lg navbar-light fill px-lg-0 py-0 px-3">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <span class="fa fa-pencil-square-o"></span> Web Programming Blog</a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="fa icon-expand fa-bars"></span>
                <span class="fa icon-close fa-times"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown @@category__active">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Categories <span class="fa fa-angle-down"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="index.php?kategori=technology">Technology posts</a>
                            <a class="dropdown-item" href="index.php?kategori=lifestyle">Lifestyle posts</a>
                        </div>
                    </li>
                    <li class="nav-item @@about__active">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                    <li class="nav-item @@about__active">
                        <a class="nav-link" href="admin.php">Admin Dashboard</a>
                    </li>
                    <div class="mobile-position">
                        <nav class="navigation">
                            <div class="theme-switch-wrapper">
                                <label class="theme-switch" for="checkbox">
                                    <input type="checkbox" id="checkbox">
                                    <div class="mode-container">
                                        <i class="gg-sun"></i>
                                        <i class="gg-moon"></i>
                                    </div>
                                </label>
                            </div>
                        </nav>
                    </div>
                    <!--/search-right-->
                    <div class="search-right mt-lg-0 mt-2">
                        <a href="#search" title="search"><span class="fa fa-search" aria-hidden="true"></span></a>
                        <!-- search popup -->
                        <div id="search" class="pop-overlay">
                            <div class="popup">
                                <h3 class="hny-title two">Search here</h3>
                                <form action="#" method="Get" class="search-box">
                                    <input type="search" placeholder="Search for blog posts" name="search" required="required"
                                        autofocus="">
                                    <button type="submit" class="btn">Search</button>
                                </form>
                                <a class="close" href="#close">×</a>
                            </div>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="w3l-homeblock1">
    <div class="container pt-lg-5 pt-md-4">
        <div class="main-content">
            <h2 class="mb-4">Recent Posts</h2>
            <?php
            if ($recentPosts) {
                if ($recentPosts->num_rows > 0) {
                    while ($row = $recentPosts->fetch_assoc()) {
                        echo "<div class='trending-post'>"; // Mengubah dari 'post' menjadi 'trending-post'
                        echo "<h5><a href='artikel.php?id=" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['judul']) . "</a></h5>";
                        echo "<p>" . nl2br(htmlspecialchars($row['isi'])) . "</p>";
                        echo "<p><strong>Views:</strong> " . htmlspecialchars($row['view']) . "</p>";
                        if ($row['images']) {
                            echo "<img src='uploads/" . htmlspecialchars($row['images']) . "' alt='Image'>";
                        }
                        echo "</div>";
                    }
                } else {
                    echo "<p>No recent posts available.</p>";
                }
            } else {
                echo "<p>Error fetching recent posts.</p>";
            }
            ?>

            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>&kategori=<?php echo htmlspecialchars($kategori); ?>">Previous</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>&kategori=<?php echo htmlspecialchars($kategori); ?>" class="<?php echo $i === $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>&kategori=<?php echo htmlspecialchars($kategori); ?>">Next</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="sidebar">
            <h3>Trending Posts</h3>
            <?php
            if ($trendingPosts) {
                if ($trendingPosts->num_rows > 0) {
                    while ($row = $trendingPosts->fetch_assoc()) {
                        echo "<div class='trending-post'>";
                        echo "<h5><a href='artikel.php?id=" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['judul']) . "</a></h5>";
                        echo "<p>" . nl2br(htmlspecialchars($row['isi'])) . "</p>";
                        echo "<p><strong>Views:</strong> " . htmlspecialchars($row['view']) . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No trending posts available.</p>";
                }
            } else {
                echo "<p>Error fetching trending posts.</p>";
            }
            ?>
        </div>

        <div class="clearfix"></div>
    </div>
</div>

<footer>
    <div class="container">
        <p class="text-center">© 2024 Web Programming Blog. All rights reserved.</p>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/theme-change.js"></script>
</body>
</html>

<?php
$conn->close();
?>

<?php
require_once "db_conn.php";

$sql = "SELECT uname, uemail, uphone, course, cmessage FROM contact_messages ORDER BY uname ASC";
$result = $conn->query($sql);
$total_enquiries = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Management - King's Dental Academy</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2c5f7f;
            --secondary: #4a9fd8;
            --accent: #f0a500;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --white: #ffffff;
            --shadow: rgba(0, 0, 0, 0.1);
            --border: #e0e0e0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 2rem 1rem;
            color: var(--dark);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header Section */
        .header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: var(--white);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-content h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header-content p {
            opacity: 0.95;
            font-size: 1rem;
        }

        .stats-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 1rem 1.5rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
        }

        .stats-badge .number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--accent);
            line-height: 1;
        }

        .stats-badge .label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-top: 0.3rem;
        }

        /* Controls Section */
        .controls {
            background: var(--white);
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px var(--shadow);
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
        }

        .search-box {
            flex: 1;
            min-width: 280px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 3rem;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 4px rgba(74, 159, 216, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 1.2rem;
        }

        .filter-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.7rem 1.2rem;
            background: var(--light);
            border: 2px solid var(--border);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .filter-btn:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .filter-btn.active {
            background: var(--secondary);
            color: var(--white);
            border-color: var(--secondary);
        }

        .export-btn {
            padding: 0.8rem 1.5rem;
            background: var(--accent);
            color: var(--dark);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .export-btn:hover {
            background: #ffc233;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(240, 165, 0, 0.3);
        }

        /* Table Container */
        .table-container {
            background: var(--white);
            border-radius: 15px;
            box-shadow: 0 8px 30px var(--shadow);
            overflow: hidden;
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        thead {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: var(--white);
        }

        th {
            padding: 1.2rem 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: linear-gradient(90deg, rgba(74, 159, 216, 0.05) 0%, transparent 100%);
            transform: scale(1.01);
        }

        td {
            padding: 1.2rem 1rem;
            color: #555;
            vertical-align: top;
        }

        td.name {
            font-weight: 600;
            color: var(--primary);
        }

        td.email {
            color: var(--secondary);
        }

        td.phone {
            font-family: 'Courier New', monospace;
            font-weight: 500;
        }

        td.course {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            background: linear-gradient(135deg, var(--accent) 0%, #ffc233 100%);
            color: var(--dark);
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
        }

        td.message {
            max-width: 300px;
            line-height: 1.6;
            color: #666;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #999;
        }

        .empty-state .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h3 {
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        /* Mobile Responsive Card View */
        @media (max-width: 900px) {
            .header {
                text-align: center;
                justify-content: center;
            }

            .header-content h1 {
                font-size: 1.5rem;
                justify-content: center;
            }

            .controls {
                flex-direction: column;
            }

            .search-box {
                width: 100%;
            }

            .filter-buttons {
                width: 100%;
                justify-content: center;
            }

            table, thead, tbody, th, td, tr {
                display: block;
                width: 100%;
            }

            thead {
                display: none;
            }

            .table-wrapper {
                overflow-x: visible;
            }

            tbody tr {
                margin-bottom: 1.5rem;
                border: 2px solid var(--border);
                border-radius: 15px;
                padding: 1.5rem;
                background: var(--white);
                box-shadow: 0 4px 15px var(--shadow);
            }

            tbody tr:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            }

            td {
                border: none;
                position: relative;
                padding: 0.8rem 0;
                padding-left: 40%;
                margin-bottom: 0.8rem;
                display: flex;
                align-items: flex-start;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                top: 0.8rem;
                font-weight: 700;
                color: var(--primary);
                width: 35%;
                font-size: 0.85rem;
                text-transform: uppercase;
            }

            td.course {
                display: inline-flex;
                margin-left: 40%;
            }

            td.message {
                max-width: 100%;
                padding-left: 0;
                display: block;
            }

            td.message::before {
                position: relative;
                display: block;
                margin-bottom: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 1rem 0.5rem;
            }

            .header {
                padding: 1.5rem 1rem;
                border-radius: 12px;
            }

            .stats-badge .number {
                font-size: 2rem;
            }
        }

        /* Back Button */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
            text-decoration: none;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-3px);
        }

        /* Scrollbar Styling */
        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: var(--light);
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: var(--secondary);
            border-radius: 10px;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <h1>
                    🦷 Enquiry Management
                </h1>
                <p>King's Dental Academy - Student Enquiries Dashboard</p>
            </div>
            <div class="stats-badge">
                <div class="number"><?php echo $total_enquiries; ?></div>
                <div class="label">Total Enquiries</div>
            </div>
            <a href="index.html" class="back-btn">← Back to Home</a>
        </div>

        <!-- Controls -->
        <div class="controls">
            <div class="search-box">
                <span class="search-icon">🔍</span>
                <input 
                    type="text" 
                    id="searchInput" 
                    placeholder="Search by name, email, course or message..."
                    autocomplete="off"
                >
            </div>
            <div class="filter-buttons">
                <button class="filter-btn active" onclick="filterTable('all')">All Courses</button>
                <button class="filter-btn" onclick="filterTable('fellowship')">Fellowship</button>
                <button class="filter-btn" onclick="filterTable('mastery')">Mastery</button>
            </div>
            <!--
                <button class="export-btn" onclick="exportToCSV()">
                    📥 Export CSV
                </button>
            -->
        </div>

        <!-- Table -->
        <div class="table-container">
            <div class="table-wrapper">
                <table id="enquiryTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Phone Number</th>
                            <th>Course Interest</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $name = htmlspecialchars($row['uname']);
                                $email = htmlspecialchars($row['uemail']);
                                $phone = htmlspecialchars($row['uphone']);
                                $course = htmlspecialchars($row['course']);
                                $message = htmlspecialchars($row['cmessage']);
                                
                                echo "<tr>
                                    <td class='name' data-label='Name'>{$name}</td>
                                    <td class='email' data-label='Email'><a style='text-decoration:none;' href='mailto:{$email}'>{$email}</a></td>
                                    <td class='phone' data-label='Phone'><a style='text-decoration:none;' href='tel:{$phone}'>{$phone}</a></td>
                                    <td data-label='Course'><span class='course'>{$course}</span></td>
                                    <td class='message' data-label='Message'>{$message}</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='empty-state'>
                                <div class='icon'>📭</div>
                                <h3>No Enquiries Yet</h3>
                            </td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Search Functionality
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("tbody tr");

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });

            updateEmptyState();
        });

        // Filter by Course Type
        function filterTable(type) {
            let rows = document.querySelectorAll("tbody tr");
            let buttons = document.querySelectorAll(".filter-btn");
            
            // Update active button
            buttons.forEach(btn => btn.classList.remove("active"));
            event.target.classList.add("active");

            rows.forEach(row => {
                let courseCell = row.querySelector("td:nth-child(4)");
                if (!courseCell) return;
                
                let courseText = courseCell.textContent.toLowerCase();
                
                if (type === "all") {
                    row.style.display = "";
                } else if (type === "fellowship" && courseText.includes("fellowship")) {
                    row.style.display = "";
                } else if (type === "mastery" && (courseText.includes("mastery") || courseText.includes("bootcamp"))) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });

            updateEmptyState();
        }

        // Update empty state visibility
        function updateEmptyState() {
            let rows = document.querySelectorAll("tbody tr");
            let visibleRows = Array.from(rows).filter(row => row.style.display !== "none");
            
            if (visibleRows.length === 0) {
                console.log("No visible rows");
            }
        }

        /*
        // Export to CSV
        function exportToCSV() {
            let table = document.getElementById("enquiryTable");
            let rows = Array.from(table.querySelectorAll("tr"));
            let csv = [];

            rows.forEach(row => {
                let cols = Array.from(row.querySelectorAll("th, td"));
                let rowData = cols.map(col => {
                    let text = col.textContent.trim();
                    // Escape quotes and wrap in quotes
                    return '"' + text.replace(/"/g, '""') + '"';
                });
                csv.push(rowData.join(","));
            });

            let csvContent = csv.join("\n");
            let blob = new Blob([csvContent], { type: "text/csv" });
            let url = URL.createObjectURL(blob);
            
            let link = document.createElement("a");
            link.href = url;
            link.download = "enquiries_" + new Date().toISOString().split('T')[0] + ".csv";
            link.click();
            
            URL.revokeObjectURL(url);
        }
        */

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>
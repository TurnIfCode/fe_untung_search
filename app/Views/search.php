<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Untung Search</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');

        /* Reset default margins and paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            width: 100%;
            font-family: 'Open Sans', sans-serif;
            background: white;
            color: #222;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 20px;
        }

        h1 {
            font-weight: 600;
            font-size: 3rem;
            margin-bottom: 30px;
            letter-spacing: 1px;
            color: #1a4378;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        form {
            display: flex;
            width: 100%;
            box-shadow: 0 4px 12px rgba(26, 67, 120, 0.15);
            border-radius: 30px;
            background: white;
            padding: 10px 20px;
            transition: box-shadow 0.3s ease;
            margin-bottom: 30px;
        }

        form:focus-within {
            box-shadow: 0 6px 20px rgba(26, 67, 120, 0.3);
        }

        input[type="text"] {
            flex-grow: 1;
            border: none;
            outline: none;
            font-size: 1.25rem;
            padding: 12px 15px;
            border-radius: 30px;
            color: #1a4378;
            font-weight: 500;
            transition: background-color 0.3s ease;
            font-family: inherit;
        }

        input[type="text"]::placeholder {
            color: #8aa4c1;
        }

        input[type="text"]:focus {
            background-color: #f0f7fc;
        }

        button {
            background-color: #1a4378;
            border: none;
            color: white;
            font-weight: 600;
            font-size: 1.15rem;
            padding: 0 25px;
            margin-left: 15px;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 8px rgba(26, 67, 120, 0.4);
            font-family: inherit;
        }

        button:hover {
            background-color: #14406e;
            box-shadow: 0 8px 14px rgba(20, 64, 110, 0.5);
        }

        @media (max-width: 768px) {
            form {
                flex-direction: row;
                padding: 15px;
                max-width: 100%;
                gap: 10px;
            }
            input[type="text"] {
                margin-bottom: 0;
                padding: 14px 20px;
                font-size: 1.2rem;
                flex-grow: 1;
            }
            button {
                margin-left: 0;
                padding: 14px 20px;
                font-size: 1.15rem;
                border-radius: 25px;
                flex-shrink: 0;
            }
        }

        @media (max-width: 480px) {
            form {
                flex-direction: column;
                padding: 15px;
            }
            input[type="text"] {
                margin-bottom: 12px;
                padding: 14px 20px;
            }
            button {
                margin-left: 0;
                padding: 12px 20px;
                font-size: 1.1rem;
            }
        }
        @media (max-width: 600px) {
            .result-item {
                flex-direction: column;
            }
            .result-image {
                margin-right: 0;
                margin-bottom: 15px;
                flex: 0 0 auto;
                max-width: 100%;
            }
            .result-content {
                flex: 1 1 auto;
            }
            .results-container {
                padding: 10px;
                width: 100%;
            }
        }
        
        @media (min-width: 769px) and (max-width: 1024px) {
            form {
                max-width: 90%;
            }
            input[type="text"] {
                font-size: 1.3rem;
                padding: 12px 18px;
            }
            button {
                font-size: 1.2rem;
                padding: 0 30px;
            }
        }

        .results-container {
            width: 100%;
            max-width: 100%;
            border-radius: 0;
            padding: 0;
            margin: 0;
            box-shadow: none;
            text-align: left;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
            overflow-x: auto;
            white-space: nowrap;
        }

        .pagination a {
            display: inline-block;
            margin: 0 5px;
            text-decoration: none;
            color: #1a0dab;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .pagination a.active {
            font-weight: bold;
            background-color: #e8f0fe;
        }

        .pagination a:hover {
            background-color: #d2e3fc;
        }

        /* Search results styles */
        .results-container {
            width: 100%;
            padding: 20px;
            text-align: left;
        }

        .result-item {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .result-image {
            margin-right: 15px;
            flex: 0 0 120px;
            max-width: 120px;
            margin-bottom: 10px;
        }
        .result-image img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }
        .result-content {
            flex: 1 1 0;
            min-width: 0;
        }
        .result-title {
            font-size: 18px;
            font-weight: bold;
            color: #1a0dab;
            text-decoration: none;
        }
        .result-title:hover {
            text-decoration: underline;
        }
        .result-description {
            color: #555;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            color: #1a0dab;
            cursor: pointer;
        }
        .pagination a.active {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1 style="color: #0088cc;">Untung Search</h1>
    <form method="post" action="<?= site_url('search') ?>">
        <input type="text" name="keyword" placeholder="Enter Search" required value="<?= isset($keyword) ? esc($keyword) : '' ?>" autocomplete="off">
        <button type="submit" style="color: white; background-color: #0088cc; border: none; border-radius: 5px; padding: 8px 16px; cursor: pointer;">Search</button>
    </form>

    <?php if (isset($results)): ?>
    <div class="results-container">
        <h2>Search Results for: <?= esc($keyword) ?></h2>

        <?php if ($source === 'database'): ?>
            <?php if (!empty($results)): ?>
                <div>
                    <?php foreach ($results as $result): ?>
                        <div class="result-item">
                            <div class="result-content">
                                <a class="result-title" href="<?= esc($result['link']) ?>" target="_blank"><?= esc($result['title']) ?></a>
                                <p style="color: gray; font-size: small; margin: 2px 0 8px 0;"><?= esc($result['link']) ?></p>
                                <p class="result-description">
                                    <?php
                                        $desc = $result['description'];
                                        if (strlen($desc) > 150) {
                                            $desc = substr($desc, 0, 150) . '...';
                                        }
                                        echo esc($desc);
                                    ?>
                                </p>
                            </div>
                            <?php if (!empty($result['image'])): ?>
                                <div class="result-image">
                                    <?php if ($source === 'database' && strpos($result['image'], 'data:image') !== 0): ?>
                                        <img src="data:image/png;base64,<?= $result['image'] ?>" alt="<?= esc($result['title']) ?>" style="width: 92px; height: 92px;">
                                    <?php else: ?>
                                        <img src="<?= esc($result['image']) ?>" alt="<?= esc($result['title']) ?>">
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (isset($keywordDetails[$result['id']]) && !empty($keywordDetails[$result['id']])): ?>
                            <div style="margin-left: 20px; margin-bottom: 20px;">
                                <h4>Keyword Details:</h4>
                                <?php foreach ($keywordDetails[$result['id']] as $detail): ?>
                                    <div class="result-item" style="border: none; padding: 5px 0;">
                                        <div class="result-content">
                                            <a class="result-title" href="<?= esc($detail['link']) ?>" target="_blank"><?= esc($detail['title']) ?></a>
                                            <p style="color: gray; font-size: small; margin: 2px 0 8px 0;"><?= esc($detail['link']) ?></p>
                                            <p class="result-description">
                                                <?php
                                                    $desc = $detail['description'];
                                                    if (strlen($desc) > 150) {
                                                        $desc = substr($desc, 0, 150) . '...';
                                                    }
                                                    echo esc($desc);
                                                ?>
                                            </p>
                                        </div>
                                        <?php if (!empty($detail['image'])): ?>
                                            <div class="result-image">
                                                <img src="<?= esc($detail['image']) ?>" alt="<?= esc($detail['title']) ?>">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No positions found for this keyword.</p>
            <?php endif; ?>
        <?php elseif ($source === 'google'): ?>
            <?php if (!empty($results)): ?>
                <div>
                    <?php foreach ($results as $result): ?>
                        <div class="result-item">
                            <div class="result-content">
                                <a class="result-title" href="<?= esc($result['link']) ?>" target="_blank"><?= esc($result['title']) ?></a>
                                <p style="color: gray; font-size: small; margin: 2px 0 8px 0;"><?= esc($result['link']) ?></p>
                                <p class="result-description">
                                    <?php
                                        $desc = $result['description'];
                                        if (strlen($desc) > 150) {
                                            $desc = substr($desc, 0, 150) . '...';
                                        }
                                        echo esc($desc);
                                    ?>
                                </p>
                            </div>
                            <?php if (!empty($result['image'])): ?>
                                <div class="result-image">
                                    <img src="<?= esc($result['image']) ?>" alt="<?= esc($result['title']) ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No results found from Google.</p>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                    <?php if ($i == $pagination['current_page']): ?>
                        <a class="active"><?= $i ?></a>
                    <?php else: ?>
                        <a href="#" onclick="submitPage(<?= $i ?>); return false;"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <script>
        function submitPage(page) {
            const form = document.querySelector('form');
            let pageInput = document.querySelector('input[name="page"]');
            if (!pageInput) {
                pageInput = document.createElement('input');
                pageInput.type = 'hidden';
                pageInput.name = 'page';
                form.appendChild(pageInput);
            }
            pageInput.value = page;
            form.submit();
        }
    </script>
</body>
</html>

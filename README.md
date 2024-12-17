# **Browsershot Library**

A custom PHP library to generate PDFs and screenshots from URLs, static HTML, or dynamic PHP files using **Headless Chrome** powered by Spatie’s Browsershot and Puppeteer.
Works in Yii2 framework.
---

## **Table of Contents**

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Usage](#usage)
    - [Generate PDF from a URL](#generate-pdf-from-a-url)
    - [Generate PDF from File](#generate-pdf-from-file)
4. [Configuration](#configuration)
5. [Troubleshooting](#troubleshooting)
6. [License](#license)
7. [Credits](#credits)

---
<a id="requirements"/>

## **Requirements**

To use this library, ensure you have the following:

- **PHP** >= 8.1
- **Composer** (PHP dependency manager)
- **Node.js** >= 14
- **Google Chrome** or **Chromium** (or any chromium based browser ie: Edge, Brave)
- **Puppeteer** (Node.js library for controlling Headless Chrome)

---
<a id="installation"/>

## **Installation**

1. **Install the Library via Composer** <br>
   Run the following command in your project directory:
   ```bash
   composer require hemike1/browsershot-yii2
   ```
   
2. **Install Node.js for npm** <br>
The next step requires npm for Puppeteer.
   - On Linux: use terminal to fetch the latest package. 
   ```bash
   sudo apt install nodejs
   # after successful install, check version with:
   node -v
   # version should be >= 14.
   ```
   - On Windows: you can download a prebuilt installer from [nodejs.org](https://nodejs.org/en/download/prebuilt-installer)


3. **Install Puppeteer** <br>
   Browsershot relies on Puppeteer to run Headless Chrome. Install it via npm in the project repository:
   ```bash
   npm install puppeteer
   # if issues persist with chromium, use the following command
   sudo npm install puppeteer --unsafe-perm=true --allow-root
   ```

4. **Verify Chrome/Chromium Installation** <br>
   Ensure Google Chrome or Chromium is installed on your system:
    - On Linux: Install Chromium:
    ```bash
    sudo apt-get update
    sudo apt-get install -y chromium-browser
    ```
    - On macOS: Download Chrome from the [official website](https://www.google.com/chrome/).
    - on Windows: 
      - Either Edge is already preinstalled, you can use that in <br> (C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe)
      - Or you already have Google Chrome installed.

---
<a id="usage"/>

## **Usage**
<a id="generate-pdf-from-a-url"/>

### **1. Generate PDF from a URL**

```php
use hemike1\Browsershot\Browsershot;

$output_path = __DIR__ . '/example.pdf';
Browsershot::createPdfFromUrl('https://example.com/site/view-pdf?id=15', $output_path);

echo "PDF saved to: $outputPath";

//or

$pdf = Browsershot::createPdfFromUrl('https://example.com/site/viewpdf?id=15', $output_path);

echo "PDF saved to: $pdf"; //Returns the output path if ran successfully.
```

---
<a id="generate-pdf-from-file"/>

### **2. Generate PDF from a PHP File**

Suppose you have a file `example.php`:

**example.php:**
```php
<!DOCTYPE html>
<html>
<body>
    <h1>Hello, <?php echo "World"; ?></h1>
    <p>Current Time: <?php echo date('Y-m-d H:i:s'); ?></p>
    <p> <?= $lorem_ipsum ?> </p>
</body>
</html>
```

You can render it and save it as a PDF:
```php
$output_path = __DIR__ . '/php-output.pdf';
Browsershot::createPdfFromHtml(__DIR__ . '/example.php', $output_path, [
    'lorem_ipsum' => $content,
]);

echo "PDF saved to: $outputPath"; // Will also return output_path
```

---
<a id="configuration"/>

## **Configuration**

The library uses default paths for Node.js and Chrome: <br>
(.exe paths on windows)

- **Node.js binary**: `/usr/bin/node`
- **Chrome binary**: `/usr/bin/google-chrome`

To customize paths, update the static properties in your code: <br>
(preferably in the index.php if the given application)
```php
Browsershot::$nodeBinary = '/custom/path/to/node';
Browsershot::$chromePath = '/custom/path/to/chrome';
```

---
<a id="troubleshooting"/>

## **Troubleshooting**

### **1. Chrome Sandbox Issues**
If you’re running this library in a restricted environment (e.g., shared hosting, Docker containers), you might need to disable Chrome’s sandbox mode:

```bash
sudo npm install puppeteer --unsafe-perm=true --allow-root
```

Add `--no-sandbox` when running Puppeteer in Browsershot:
```php
Browsershot::url('https://example.com')
    ->setOption('args', ['--no-sandbox'])
    ->pdf()
    ->save('/path/to/file.pdf');
```

### **2. "Chrome Executable Not Found" Error**
Ensure Chrome/Chromium is installed and accessible via the system path.

- Verify with:
   ```bash
   which google-chrome
   ```

---
<a id="license"/>

## **License**

This library is released under the [MIT License](https://github.com/hemike1/Browsershot-yii2?tab=MIT-1-ov-file).

---
<a id="credits"/>

## **Credits**

- Built on top of [Spatie's Browsershot](https://github.com/spatie/browsershot).
- Headless Chrome powered by [Puppeteer](https://pptr.dev/).

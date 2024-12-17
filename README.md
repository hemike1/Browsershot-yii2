# **Browsershot Library**

A custom PHP library to generate PDFs and screenshots from URLs, static HTML, or dynamic PHP files using **Headless Chrome** powered by Spatie’s Browsershot and Puppeteer.

---

## **Table of Contents**

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Usage](#usage)
    - [Generate PDF from a URL](#generate-pdf-from-a-url)
    - [Generate PDF from Raw HTML](#generate-pdf-from-raw-html)
    - [Generate PDF from a PHP File](#generate-pdf-from-a-php-file)
4. [Configuration](#configuration)
5. [Troubleshooting](#troubleshooting)
6. [License](#license)

---

## **Requirements**

To use this library, ensure you have the following:

- **PHP** >= 8.2
- **Composer** (PHP dependency manager)
- **Node.js** >= 14
- **Google Chrome** or **Chromium**
- **Puppeteer** (Node.js library for controlling Headless Chrome)

---

## **Installation**

1. **Install the Library via Composer**
   Run the following command in your project directory:
   ```bash
   composer require hemike1/browsershot-yii2
   ```

2. **Install Puppeteer**
   Browsershot relies on Puppeteer to run Headless Chrome. Install it via npm:
   ```bash
   npm install puppeteer
   ```

3. **Verify Chrome Installation**
   Ensure Google Chrome or Chromium is installed on your system:
    - On Linux: Install Chromium:
      ```bash
      sudo apt-get update
      sudo apt-get install -y chromium-browser
      ```
    - On macOS/Windows: Download Chrome from the [official website](https://www.google.com/chrome/).

---

## **Usage**

### **1. Generate PDF from a URL**

```php
use hemike1\Browsershot\Browsershot;

$outputPath = __DIR__ . '/example.pdf';
Browsershot::createPdfFromUrl('https://example.com', $outputPath);

echo "PDF saved to: $outputPath";
```

---

### **2. Generate PDF from Raw HTML**

```php
$outputPath = __DIR__ . '/html-output.pdf';
$htmlContent = '<h1>Hello, World!</h1><p>This is a test PDF.</p>';

Browsershot::createPdfFromHtml($htmlContent, $outputPath);

echo "PDF saved to: $outputPath";
```

---

### **3. Generate PDF from a PHP File**

Suppose you have a file `example.php`:

**example.php:**
```php
<!DOCTYPE html>
<html>
<body>
    <h1>Hello, <?php echo "World"; ?></h1>
    <p>Current Time: <?php echo date('Y-m-d H:i:s'); ?></p>
</body>
</html>
```

You can render it and save it as a PDF:
```php
$outputPath = __DIR__ . '/php-output.pdf';
Browsershot::createPdfFromHtml(__DIR__ . '/example.php', $outputPath);

echo "PDF saved to: $outputPath";
```

---

## **Configuration**

The library uses default paths for Node.js and Chrome:

- **Node.js binary**: `/usr/bin/node`
- **Chrome binary**: `/usr/bin/google-chrome`

To customize paths, update the static properties in your code:

```php
Browsershot::$nodeBinary = '/custom/path/to/node';
Browsershot::$chromePath = '/custom/path/to/chrome';
```

---

## **Troubleshooting**

### **1. Chrome Sandbox Issues**
If you’re running this library in a restricted environment (e.g., shared hosting, Docker containers), you might need to disable Chrome’s sandbox mode:

```bash
npm install puppeteer --unsafe-perm=true
```

Add `--no-sandbox` when running Puppeteer in Browsershot:
```php
\Spatie\Browsershot\Browsershot::url('https://example.com')
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

## **License**

This library is released under the MIT License.

---

## **Credits**

- Built on top of [Spatie's Browsershot](https://github.com/spatie/browsershot).
- Headless Chrome powered by [Puppeteer](https://pptr.dev/).

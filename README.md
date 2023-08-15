# Piwigo Validated By Plugin
![Piwigo Logo](https://lintyserver.cloud/assets/img/piwigo-logo.svg)

A Piwigo plugin that allows administrators to manage image validation status through a new `validated_by` field. This plugin also exposes an API endpoint for batch management and viewing/editing the `validated_by` field.

## Features
- **Batch Management**: Easily manage the validation status of multiple images at once.
- **API Integration**: View and edit the `validated_by` field through the Piwigo API.
- **Admin Only Access**: Ensures that only administrators can modify the `validated_by` field.

## Getting Started

### Prerequisites
- A running Piwigo instance.
- Admin access to the Piwigo instance.

### Installation
1. Clone this repository:
```bash
git clone https://github.com/LintyDev/piwigo-validated-by
```

2. Navigate to the project directory:
```bash
cd piwigo-validated-by-plugin
```

3. Copy the `validated_by` folder into the `plugins` directory of your Piwigo installation.

4. Go to the Piwigo admin panel, navigate to the Plugins section, and activate the `validated_by` plugin.

## Usage
After installation, a new field `validated_by` will be available for each image. Administrators can use this field to mark images as validated and can manage this field through the Piwigo API.

## Contributing
Contributions are what make the open-source community such an amazing place to learn, inspire, and create. Any contributions you make are greatly appreciated.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License
Distributed under the MIT License. See `LICENSE` for more information.

## Contact
Linty - [@lintydev](https://twitter.com/lintydev)

import fs from 'fs/promises';
import path from 'path';
import {pathToFileURL} from 'url';

async function collectModuleAssetsPaths(paths, mainPackageDir) {
    try {
        const authorsDirectories = await fs.readdir(mainPackageDir);

        for (const authorDir of authorsDirectories) {
            // Skip files like '.DS_Store' or 'composer.json' directly in this directory
            const authorPath = path.join(mainPackageDir, authorDir);
            const stat = await fs.stat(authorPath);
            if (!stat.isDirectory()) {
                continue;
            }

            const packagesDirectories = await fs.readdir(authorPath);
            for (const packageDir of packagesDirectories) {
                const packagePath = path.join(authorPath, packageDir);
                const stat = await fs.stat(packagePath);
                if (!stat.isDirectory()) {
                    continue;
                }
                //kiểm tra xem trong thư mục package có file vite.config.js không
                const viteConfigPath = path.join(packagePath, 'vite.config.js').replace(/\\/g, '/');
                try {
                    await fs.access(viteConfigPath);
                    const moduleConfig = await import(pathToFileURL(viteConfigPath).href);

                    if (moduleConfig.paths && Array.isArray(moduleConfig.paths)) {
                        paths.push(...moduleConfig.paths);
                    }
                } catch (error) {
                    // console.error(`Error accessing or importing from ${viteConfigPath}: ${error}`);
                }
            }
        }
    } catch (error) {
        console.error(`Error reading module statuses or module configurations: ${error}`);
    }

    return paths;
}

export default collectModuleAssetsPaths;

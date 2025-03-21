from PIL import Image
import os

def process_images(input_dir, output_dir, size=(800, 600)):
    if not os.path.exists(output_dir):
        os.makedirs(output_dir)
        
    for filename in os.listdir(input_dir):
        if filename.endswith(('.jpg', '.png', '.jpeg')):
            try:
                img = Image.open(os.path.join(input_dir, filename))
                # Resize
                img_resized = img.resize(size, Image.Resampling.LANCZOS)
                # Optimize
                img_resized.save(os.path.join(output_dir, filename), quality=85, optimize=True)
                print(f"Processed: {filename}")
            except Exception as e:
                print(f"Error processing {filename}: {e}")

if __name__ == "__main__":
    process_images('original_images', 'images')
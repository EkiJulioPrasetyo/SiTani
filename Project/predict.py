import os
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'

import sys
import io
import logging
import numpy as np
import tensorflow as tf
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing import image

# Matikan semua log TensorFlow
tf.get_logger().setLevel('ERROR')
logging.getLogger('tensorflow').setLevel(logging.ERROR)

# Pastikan stdout UTF-8 (hindari error charmap)
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

model = load_model("model_cnn_tanaman.keras")
labels = ['Healthy', 'Leaf Curl', 'Leaf Spot', 'White Fly', 'Yellowish']

img_path = sys.argv[1]

img = image.load_img(img_path, target_size=(224, 224))
img_array = image.img_to_array(img)
img_array = np.expand_dims(img_array, axis=0)
img_array = img_array / 255.0

# Prediksi tanpa progress bar
pred = model.predict(img_array, verbose=0)

# Prediksi berdasarkan probabilitas tertinggi
predicted_index = np.argmax(pred)
predicted_label = labels[predicted_index]

print(predicted_label)
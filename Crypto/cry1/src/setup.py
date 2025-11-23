import os
import random

key_size = 1024 * 1024 
key_data = os.urandom(key_size)

with open('key.bin', 'wb') as f:
    f.write(key_data)

jpg_header = b'\xff\xd8\xff\xe0\x00\x10JFIF\x00\x01'

flag_content = jpg_header + os.urandom(500) + b'lfga[oF_courSE~1KnOwJPG&Xor_VERyWelL!]' + os.urandom(100)

secret_offset = random.randint(1000, key_size - len(flag_content) - 1)

encrypted_data = bytearray()

for i in range(len(flag_content)):
    encrypted_data.append(flag_content[i] ^ key_data[secret_offset + i])

with open('flag.enc', 'wb') as f:
    f.write(encrypted_data)

print(f"Offset: {secret_offset}")

demo_code = r'''def xor_decrypt(enc_file, key_file, offset):
    with open(enc_file, 'rb') as f1:
        ciphertext = f1.read()
    with open(key_file, 'rb') as f2:
        f2.seek(offset)
        key_stream = f2.read(len(ciphertext))
    plaintext = bytearray()
    for i in range(len(ciphertext)):
        plaintext.append(ciphertext[i] ^ key_stream[i])
    return plaintext

if __name__ == '__main__':
    OFFSET = 0 
    result = xor_decrypt('flag.enc', 'key.bin', OFFSET)
    with open('decrypt_file', 'wb') as f:
        f.write(result)
    print("ok.")
'''

with open('decrypt.py', 'w', encoding='utf-8') as f:
    f.write(demo_code)
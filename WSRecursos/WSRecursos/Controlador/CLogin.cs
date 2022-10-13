using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CLogin
    {
        public List<ELogin> Listar_Login(SqlConnection con, String usuario, String password)
        {
            List<ELogin> lELogin = null;
            SqlCommand cmd = new SqlCommand("ASP_LOGIN", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@usuario", SqlDbType.VarChar).Value = usuario;
            cmd.Parameters.AddWithValue("@password", SqlDbType.VarChar).Value = password;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lELogin = new List<ELogin>();

                ELogin obELogin = null;
                while (drd.Read())
                {
                    obELogin = new ELogin();
                    obELogin.v_dni = drd["v_dni"].ToString();
                    obELogin.v_nombre = drd["v_nombre"].ToString();
                    obELogin.v_correo = drd["v_correo"].ToString();
                    obELogin.v_codigo = drd["v_codigo"].ToString();
                    obELogin.v_estado = drd["v_estado"].ToString();
                    obELogin.i_idperfil = drd["i_idperfil"].ToString();
                    obELogin.v_perfil = drd["v_perfil"].ToString();
                    obELogin.v_foto = drd["v_foto"].ToString();
                    obELogin.v_ruc = drd["v_ruc"].ToString();
                    obELogin.v_razon = drd["v_razon"].ToString();
                    obELogin.v_nombre_completo = drd["v_nombre_completo"].ToString();
                    obELogin.v_ruta = drd["v_ruta"].ToString();
                    obELogin.v_firma = drd["v_firma"].ToString();
                    obELogin.i_flex = Convert.ToInt32(drd["i_flex"].ToString());
                    obELogin.i_remoto = Convert.ToInt32(drd["i_remoto"].ToString());
                    obELogin.i_venta = Convert.ToInt32(drd["i_venta"].ToString());
                    obELogin.i_zona = Convert.ToInt32(drd["i_zona"].ToString());
                    obELogin.i_local = Convert.ToInt32(drd["i_local"].ToString());
                    obELogin.d_nacimiento = drd["d_nacimiento"].ToString();
                    obELogin.v_cargo = drd["v_cargo"].ToString();
                    obELogin.v_nombres = drd["v_nombres"].ToString();
                    obELogin.v_apellidos = drd["v_apellidos"].ToString();
                    obELogin.v_pais = drd["v_pais"].ToString();
                    obELogin.v_departamento = drd["v_departamento"].ToString();
                    obELogin.v_provincia = drd["v_provincia"].ToString();
                    obELogin.v_distrito = drd["v_distrito"].ToString();
                    obELogin.v_direccion = drd["v_direccion"].ToString();
                    obELogin.v_referencia = drd["v_referencia"].ToString();
                    obELogin.i_cliente = Convert.ToInt32(drd["i_cliente"].ToString());
                    obELogin.i_cumpleanios = Convert.ToInt32(drd["i_cumpleanios"].ToString());
                    lELogin.Add(obELogin);
                }
                drd.Close();
            }

            return (lELogin);
        }
    }
}
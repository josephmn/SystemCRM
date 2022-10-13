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
    public class CConfiguracionCorreo
    {
        public List<EConfiguracionCorreo> ConfiguracionCorreo(SqlConnection con)
        {
            List<EConfiguracionCorreo> lEConfiguracionCorreo = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_CORREO_CONFIGURACION", con);
            cmd.CommandType = CommandType.StoredProcedure;
            
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEConfiguracionCorreo = new List<EConfiguracionCorreo>();

                EConfiguracionCorreo obEConfiguracionCorreo = null;
                while (drd.Read())
                {
                    obEConfiguracionCorreo = new EConfiguracionCorreo();
                    obEConfiguracionCorreo.v_correo_salida = drd["v_correo_salida"].ToString();
                    obEConfiguracionCorreo.v_password = drd["v_password"].ToString();
                    obEConfiguracionCorreo.v_nombre_salida = drd["v_nombre_salida"].ToString();
                    obEConfiguracionCorreo.v_servidor_entrante = drd["v_servidor_entrante"].ToString();
                    obEConfiguracionCorreo.i_puerto = Convert.ToInt32(drd["i_puerto"].ToString());
                    lEConfiguracionCorreo.Add(obEConfiguracionCorreo);
                }
                drd.Close();
            }

            return (lEConfiguracionCorreo);
        }
    }
}
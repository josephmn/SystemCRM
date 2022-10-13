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
    public class CRecuperarCorreo
    {
        public List<ERecuperarCorreo> Listar_RecuperarCorreo(SqlConnection con, String correo)
        {
            List<ERecuperarCorreo> lERecuperarCorreo = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTA_CORREO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@correo", SqlDbType.Int).Value = correo;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lERecuperarCorreo = new List<ERecuperarCorreo>();

                ERecuperarCorreo obERecuperarCorreo = null;
                while (drd.Read())
                {
                    obERecuperarCorreo = new ERecuperarCorreo();
                    obERecuperarCorreo.v_dni = drd["v_dni"].ToString();
                    obERecuperarCorreo.v_nombre = drd["v_nombre"].ToString();
                    obERecuperarCorreo.v_correo = drd["v_correo"].ToString();
                    obERecuperarCorreo.v_regclave = drd["v_regclave"].ToString();
                    lERecuperarCorreo.Add(obERecuperarCorreo);
                }
                drd.Close();
            }

            return (lERecuperarCorreo);
        }
    }
}
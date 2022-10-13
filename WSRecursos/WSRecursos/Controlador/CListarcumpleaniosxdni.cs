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
    public class CListarcumpleaniosxdni
    {
        public List<EListarcumpleaniosxdni> Listarcumpleaniosxdni(SqlConnection con, String dni)
        {
            List<EListarcumpleaniosxdni> lEListarcumpleaniosxdni = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_VACACIONES_CUMPLEANIOS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarcumpleaniosxdni = new List<EListarcumpleaniosxdni>();

                EListarcumpleaniosxdni obEListarcumpleaniosxdni = null;
                while (drd.Read())
                {
                    obEListarcumpleaniosxdni = new EListarcumpleaniosxdni();
                    obEListarcumpleaniosxdni.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarcumpleaniosxdni.i_mes = Convert.ToInt32(drd["i_mes"].ToString());
                    obEListarcumpleaniosxdni.v_mes = drd["v_mes"].ToString();
                    obEListarcumpleaniosxdni.d_finicio = drd["d_finicio"].ToString();
                    obEListarcumpleaniosxdni.d_ffin = drd["d_ffin"].ToString();
                    obEListarcumpleaniosxdni.i_dias = Convert.ToInt32(drd["i_dias"].ToString());
                    obEListarcumpleaniosxdni.v_tipo = drd["v_tipo"].ToString();
                    obEListarcumpleaniosxdni.v_color_tipo = drd["v_color_tipo"].ToString();
                    obEListarcumpleaniosxdni.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEListarcumpleaniosxdni.v_estado = drd["v_estado"].ToString();
                    obEListarcumpleaniosxdni.v_color = drd["v_color"].ToString();
                    obEListarcumpleaniosxdni.d_fregistro = drd["d_fregistro"].ToString();
                    obEListarcumpleaniosxdni.d_faprobacion = drd["d_faprobacion"].ToString();
                    lEListarcumpleaniosxdni.Add(obEListarcumpleaniosxdni);
                }
                drd.Close();
            }

            return (lEListarcumpleaniosxdni);
        }
    }
}
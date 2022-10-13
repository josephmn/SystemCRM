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
    public class CControlRemoto
    {
        public List<EControlRemoto> ControlRemoto(SqlConnection con, String dnijefe, Int32 anhio, Int32 mes)
        {
            List<EControlRemoto> lEControlRemoto = null;
            SqlCommand cmd = new SqlCommand("ASP_CONTROL_TABLA_REMOTO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dnijefe", SqlDbType.VarChar).Value = dnijefe;
            cmd.Parameters.AddWithValue("@anhio", SqlDbType.Int).Value = anhio;
            cmd.Parameters.AddWithValue("@mes", SqlDbType.Int).Value = mes;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEControlRemoto = new List<EControlRemoto>();

                EControlRemoto obEControlRemoto = null;
                while (drd.Read())
                {
                    obEControlRemoto = new EControlRemoto();
                    obEControlRemoto.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEControlRemoto.v_dni = drd["v_dni"].ToString();
                    obEControlRemoto.v_nombre = drd["v_nombre"].ToString();
                    obEControlRemoto.i_semana = Convert.ToInt32(drd["i_semana"].ToString());
                    obEControlRemoto.v_descripcion = drd["v_descripcion"].ToString();
                    obEControlRemoto.i_mes = Convert.ToInt32(drd["i_mes"].ToString());
                    obEControlRemoto.i_anhio = Convert.ToInt32(drd["i_anhio"].ToString());
                    obEControlRemoto.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEControlRemoto.v_estado = drd["v_estado"].ToString();
                    obEControlRemoto.v_color = drd["v_color"].ToString();
                    obEControlRemoto.SEMANA1 = drd["SEMANA1"].ToString();
                    obEControlRemoto.SEMANA2 = drd["SEMANA2"].ToString();
                    obEControlRemoto.SEMANA3 = drd["SEMANA3"].ToString();
                    obEControlRemoto.SEMANA4 = drd["SEMANA4"].ToString();
                    obEControlRemoto.SEMANA5 = drd["SEMANA5"].ToString();
                    obEControlRemoto.d_faprobacion = drd["d_faprobacion"].ToString();
                    lEControlRemoto.Add(obEControlRemoto);
                }
                drd.Close();
            }

            return (lEControlRemoto);
        }
    }
}
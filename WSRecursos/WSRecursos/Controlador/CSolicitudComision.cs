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
    public class CSolicitudComision
    {
        public List<EMantenimiento> SolicitudComision(SqlConnection con, String dni, String fecha, String horainicio, String horafin, String asunto, String fundamentacion, Int32 tipocomision)
        {
            List<EMantenimiento> lEMantenimiento = null;
            SqlCommand cmd = new SqlCommand("ASP_VALIDAR_COMISION", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlParameter par1 = cmd.Parameters.Add("@dni", SqlDbType.VarChar);
            par1.Direction = ParameterDirection.Input;
            par1.Value = dni;
            SqlParameter par2 = cmd.Parameters.Add("@fecha", SqlDbType.VarChar);
            par2.Direction = ParameterDirection.Input;
            par2.Value = fecha;
            SqlParameter par3 = cmd.Parameters.Add("@horainicio", SqlDbType.VarChar);
            par3.Direction = ParameterDirection.Input;
            par3.Value = horainicio;
            SqlParameter par4 = cmd.Parameters.Add("@horafin", SqlDbType.VarChar);
            par4.Direction = ParameterDirection.Input;
            par4.Value = horafin;
            SqlParameter par5 = cmd.Parameters.Add("@asunto", SqlDbType.VarChar);
            par5.Direction = ParameterDirection.Input;
            par5.Value = asunto;
            SqlParameter par6 = cmd.Parameters.Add("@fundamentacion", SqlDbType.VarChar);
            par6.Direction = ParameterDirection.Input;
            par6.Value = fundamentacion;
            SqlParameter par7 = cmd.Parameters.Add("@tipocomision", SqlDbType.Int);
            par7.Direction = ParameterDirection.Input;
            par7.Value = tipocomision;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEMantenimiento = new List<EMantenimiento>();

                EMantenimiento obEMantenimiento = null;
                while (drd.Read())
                {
                    obEMantenimiento = new EMantenimiento();
                    obEMantenimiento.v_icon = drd["v_icon"].ToString();
                    obEMantenimiento.v_title = drd["v_title"].ToString();
                    obEMantenimiento.v_text = drd["v_text"].ToString();
                    obEMantenimiento.i_timer = Convert.ToInt32(drd["i_timer"].ToString());
                    obEMantenimiento.i_case = Convert.ToInt32(drd["i_case"].ToString());
                    obEMantenimiento.v_progressbar = Convert.ToBoolean(drd["v_progressbar"].ToString());
                    lEMantenimiento.Add(obEMantenimiento);
                }
                drd.Close();
            }

            return (lEMantenimiento);
        }
    }
}
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
    public class CLocal
    {
        public List<ELocal> Listar_Local(SqlConnection con, Int32 id, Int32 zona)
        {
            List<ELocal> lELocal = null;
            SqlCommand cmd = new SqlCommand("ASP_LOCAL", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlParameter par1 = cmd.Parameters.Add("@id", SqlDbType.Int);
            par1.Direction = ParameterDirection.Input;
            par1.Value = id;

            SqlParameter par2 = cmd.Parameters.Add("@zona", SqlDbType.Int);
            par2.Direction = ParameterDirection.Input;
            par2.Value = zona;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lELocal = new List<ELocal>();

                ELocal obELocal = null;
                while (drd.Read())
                {
                    obELocal = new ELocal();
                    obELocal.i_codigo = drd["i_codigo"].ToString();
                    obELocal.v_descripcion = drd["v_descripcion"].ToString();
                    obELocal.v_hora_inicio = drd["v_hora_inicio"].ToString();
                    obELocal.v_hora_fin = drd["v_hora_fin"].ToString();
                    obELocal.v_tolerancia = drd["v_tolerancia"].ToString();
                    obELocal.i_tipo_asistencia = drd["i_tipo_asistencia"].ToString();
                    obELocal.v_tipo_asistencia = drd["v_tipo_asistencia"].ToString();
                    obELocal.i_zona = drd["i_zona"].ToString();
                    obELocal.v_zona = drd["v_zona"].ToString();
                    obELocal.i_estado = drd["i_estado"].ToString();
                    obELocal.v_estado = drd["v_estado"].ToString();
                    obELocal.v_color_estado = drd["v_color_estado"].ToString();
                    obELocal.v_abreviatura = drd["v_abreviatura"].ToString();
                    lELocal.Add(obELocal);
                }
                drd.Close();
            }

            return (lELocal);
        }
    }
}